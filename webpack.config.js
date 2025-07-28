const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

const rwd = require('./assets/rwd/webpack.config');
const admin = require('./assets/admin/webpack.config');

module.exports = [rwd, admin];
