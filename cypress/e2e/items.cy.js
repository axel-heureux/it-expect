describe('Gestion des items', () => {
    it('affiche la liste et ouvre la modal de création', () => {
        cy.visit('/');

        cy.contains('h1', 'Liste des items').should('be.visible');
        cy.get('[data-bs-target="#createItemModal"]').click();

        cy.get('#createItemModal').should('be.visible');
        cy.get('#create-item-form').should('be.visible');
        cy.get('#name').should('be.visible');
        cy.get('#price').should('be.visible');
        cy.get('#stock').should('be.visible');
    });
});