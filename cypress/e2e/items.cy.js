describe('Gestion des items', () => {
    const openCreateModal = () => {
        cy.get('[data-bs-target="#createItemModal"]').click();
        cy.get('#createItemModal').should('be.visible');
    };

    const fillCreateForm = (name, price, stock) => {
        cy.get('#name').clear().type(name);
        cy.get('#price').clear().type(price);
        cy.get('#stock').clear().type(stock);
        cy.get('#create-item-form').submit();
    };

    it('affiche la liste et ouvre la modal de création', () => {
        cy.visit('/');

        cy.contains('h1', 'Liste des items').should('be.visible');
        openCreateModal();

        cy.get('#createItemModal').should('be.visible');
        cy.get('#create-item-form').should('be.visible');
        cy.get('#name').should('be.visible');
        cy.get('#price').should('be.visible');
        cy.get('#stock').should('be.visible');
    });

    it('rejette un prix non numérique', () => {
        cy.visit('/');
        openCreateModal();
        fillCreateForm('Souris invalide', 'abc', '5');

        cy.get('#createItemModal').should('be.visible');
        cy.get('#price').should('have.class', 'is-invalid');
        cy.contains('.invalid-feedback', 'Ce champ doit être un nombre.').should('be.visible');
    });

    it('ajoute un item valide et l affiche dans la liste', () => {
        const name = `Cypress ${Date.now()}`;

        cy.visit('/');
        openCreateModal();
        fillCreateForm(name, '49.90', '10');

        cy.contains('[data-item-card]', name).should('be.visible');
        cy.contains('[data-item-card]', '49,90 €').should('be.visible');
        cy.contains('[data-item-card]', '10 unité(s)').should('be.visible');
    });

    it('affiche la rupture de stock pour un item à zéro', () => {
        const name = `Rupture Cypress ${Date.now()}`;

        cy.visit('/');
        openCreateModal();
        fillCreateForm(name, '1', '0');

        cy.contains('[data-item-card]', name)
            .should('contain.text', 'Rupture de stock');
    });

    it('supprime un item après confirmation sans recharger la page', () => {
        const name = `Suppression Cypress ${Date.now()}`;

        cy.visit('/');
        openCreateModal();
        fillCreateForm(name, '2', '1');

        cy.intercept('POST', '**/items/delete').as('deleteItem');
        cy.on('window:confirm', () => true);
        cy.contains('[data-item-card]', name)
            .find('.delete-form button[type="submit"]')
            .click();
        cy.wait('@deleteItem').its('response.statusCode').should('eq', 200);
        cy.contains('[data-item-card]', name).should('not.exist');
    });
});