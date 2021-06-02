"# ProductDataBundle" 

add "Starfruit\\\ProductDataBundle\\\\": "path/ProductDataBundle" to composer.json autoload.psr-4

add config.yaml : pimcore.bundles.search_paths: - starfruit/ProductDataBundle

bin/console assets:install

bin/console ecommerce:indexservice:bootstrap --create-or-update-index-structure

php bin/console ecommerce:indexservice:bootstrap --update-index
