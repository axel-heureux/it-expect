const { defineConfig } = require('cypress');

module.exports = defineConfig({
    allowCypressEnv: false,
    e2e: {
        baseUrl: 'http://localhost/it-expect/public',
        specPattern: 'cypress/e2e/**/*.cy.js',
        supportFile: false,
    },
});