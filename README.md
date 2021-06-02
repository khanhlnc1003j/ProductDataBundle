"# ProductDataBundle" 

add "Starfruit\\\ProductDataBundle\\\\": "path/ProductDataBundle" to composer.json autoload.psr-4

add config.yaml : pimcore.bundles.search_paths: - starfruit/ProductDataBundle

bin/console assets:install
