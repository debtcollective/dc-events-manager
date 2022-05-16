/**
 * Term Selector
 *
 * Usage:
	<TermSelector {...{ setAttributes, ...props }} />
 */
import { decodeEntities } from '@wordpress/html-entities';


const { __ } = wp.i18n;
const {
    SelectControl,
    Spinner,
} = wp.components;
const { withSelect } = wp.data;
const {
    Component
} = wp.element;

class TermSelector extends Component {
    _isMounted = false;
    
	constructor() {
        super(...arguments);
        
        this.state = {
            term: '',
            label: '',
            options: [],
            loading: false
        }
        
        this.setTerm = this.setTerm.bind(this);
        this.getOptions = this.getOptions.bind(this);
    }

    componentDidMount() {
        this._isMounted = true;

        this.setState({
			loading: true,
        });

        this.getOptions();
    }

    componentDidUpdate( prevProps ) {
        if (this.props.terms !== prevProps.terms) {
            this.getOptions();
        }

        if (this.props.attributes.taxonomy !== prevProps.attributes.taxonomy) {
             this.handleTaxChange();
        }
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    setTerm( term ) { 
        term = parseInt(term);
        this.props.setAttributes({ term });
    }

    getOptions() {
        if (Array.isArray(this.props.terms) && this.props.terms.length) {
            console.log( this.props );
            let options = [{
                value: 0,
                label: this.props.attributes.taxonomy.name
            }];
            
            this.props.terms.map(term => {
                options.push({
                    value: term.id,
                    label: decodeEntities(term.name)
                });

                this.setState({});
            });
            
            this.setState({
                options: options,
                loading: false
            } );
        }
    }

    handleTaxChange() {
        this.props.setAttributes({
            term: 0,
        });
    }

    capitalize(string)  {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

	/**
	 * Must return a single DOM node, hence the anonymous wrapper
	 */
    render() {
        const { attributes: { term, label }, terms } = this.props;
        const { options } = this.state;
        const hasOptions = Array.isArray(options) && options.length;

        if ( ! hasOptions ) {
            return (
                <div>
                    { __( 'Loading...', 'dc-events-manager' ) }
                    <Spinner />
                </div>
            );
        }
        
        return (
            <>
                <SelectControl
                    label={label}
                    value={term}
                    options={options}
                    onChange={this.setTerm}
                />
            </>
		);
	}
}

export default withSelect((select, props) => {
    const { attributes: { taxonomy } } = props;
    const { getEntityRecords } = select('core');
    const query = {
        hide_empty: true
    }

    console.log( 'From term selector', taxonomy, props );


    return {
        terms: getEntityRecords( 'taxonomy', taxonomy.slug, query )
    }

} )( TermSelector );