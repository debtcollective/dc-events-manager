<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb6453e532a437fcc54b5e8899a4ba443
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DCEventsManager\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DCEventsManager\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'DCEventsManager\\App\\Admin\\Admin' => __DIR__ . '/../..' . '/src/App/Admin/Admin.php',
        'DCEventsManager\\App\\Admin\\Options' => __DIR__ . '/../..' . '/src/App/Admin/Options.php',
        'DCEventsManager\\App\\Blocks\\Blocks' => __DIR__ . '/../..' . '/src/App/Blocks/Blocks.php',
        'DCEventsManager\\App\\Blocks\\Fields\\Fields' => __DIR__ . '/../..' . '/src/App/Blocks/Fields/Fields.php',
        'DCEventsManager\\App\\Blocks\\Fields\\Meta' => __DIR__ . '/../..' . '/src/App/Blocks/Fields/Meta.php',
        'DCEventsManager\\App\\Blocks\\Patterns' => __DIR__ . '/../..' . '/src/App/Blocks/Patterns.php',
        'DCEventsManager\\App\\Frontend\\Frontend' => __DIR__ . '/../..' . '/src/App/Frontend/Frontend.php',
        'DCEventsManager\\App\\General\\ContentFilters' => __DIR__ . '/../..' . '/src/App/General/ContentFilters.php',
        'DCEventsManager\\App\\General\\CustomFields' => __DIR__ . '/../..' . '/src/App/General/CustomFields.php',
        'DCEventsManager\\App\\General\\General' => __DIR__ . '/../..' . '/src/App/General/General.php',
        'DCEventsManager\\App\\General\\PostTypes\\PostTypes' => __DIR__ . '/../..' . '/src/App/General/PostTypes/PostTypes.php',
        'DCEventsManager\\App\\General\\Queries' => __DIR__ . '/../..' . '/src/App/General/Queries.php',
        'DCEventsManager\\App\\General\\Settings' => __DIR__ . '/../..' . '/src/App/General/Settings.php',
        'DCEventsManager\\App\\General\\Taxonomies\\EventCrmTag' => __DIR__ . '/../..' . '/src/App/General/Taxonomies/EventCrmTag.php',
        'DCEventsManager\\App\\General\\Taxonomies\\Taxonomies' => __DIR__ . '/../..' . '/src/App/General/Taxonomies/Taxonomies.php',
        'DCEventsManager\\App\\Integration\\ActionNetwork' => __DIR__ . '/../..' . '/src/App/Integration/ActionNetwork.php',
        'DCEventsManager\\App\\Integration\\CustomConditionals' => __DIR__ . '/../..' . '/src/App/Integration/CustomConditionals.php',
        'DCEventsManager\\App\\Integration\\Integration' => __DIR__ . '/../..' . '/src/App/Integration/Integration.php',
        'DCEventsManager\\App\\Integration\\RestFilters' => __DIR__ . '/../..' . '/src/App/Integration/RestFilters.php',
        'DCEventsManager\\App\\Integration\\Webhooks' => __DIR__ . '/../..' . '/src/App/Integration/Webhooks.php',
        'DCEventsManager\\Common\\Abstracts\\Base' => __DIR__ . '/../..' . '/src/Common/Abstracts/Base.php',
        'DCEventsManager\\Common\\Abstracts\\GetData' => __DIR__ . '/../..' . '/src/Common/Abstracts/GetData.php',
        'DCEventsManager\\Common\\Abstracts\\PostType' => __DIR__ . '/../..' . '/src/Common/Abstracts/PostType.php',
        'DCEventsManager\\Common\\Abstracts\\Taxonomy' => __DIR__ . '/../..' . '/src/Common/Abstracts/Taxonomy.php',
        'DCEventsManager\\Common\\I18n' => __DIR__ . '/../..' . '/src/Common/I18n.php',
        'DCEventsManager\\Common\\Loader' => __DIR__ . '/../..' . '/src/Common/Loader.php',
        'DCEventsManager\\Common\\Plugin' => __DIR__ . '/../..' . '/src/Common/Plugin.php',
        'DCEventsManager\\Common\\Traits\\Singleton' => __DIR__ . '/../..' . '/src/Common/Traits/Singleton.php',
        'DCEventsManager\\Common\\Util\\TemplateLoader' => __DIR__ . '/../..' . '/src/Common/Util/TemplateLoader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb6453e532a437fcc54b5e8899a4ba443::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb6453e532a437fcc54b5e8899a4ba443::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb6453e532a437fcc54b5e8899a4ba443::$classMap;

        }, null, ClassLoader::class);
    }
}
