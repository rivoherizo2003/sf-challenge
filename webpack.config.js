var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // will create web/build/app.js and web/build/app.css
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/scss/app.scss')
    //authentication
    .addStyleEntry('css/signIn', './assets/scss/signIn/signIn.scss')
    //add supplier
    .addEntry('js/supplier/addSupplier', './assets/js/supplier/addSupplier.js')
    //add movement \assets\js\movement\movement.js
    .addEntry('js/movement/addMovement', './assets/js/movement/addMovement.js')
    //customer order list
    .addEntry('js/customer-order/listOrderCustomer', './assets/js/order/listOrderCustomer.js')
    .addEntry('js/customer-order/addOrderCustomer', './assets/js/order/addOrderCustomer.js')

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // enable source maps during development
    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()

// allow sass/scss files to be processed
   .enableSassLoader()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();