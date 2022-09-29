/// <reference types="cypress" />

describe('User can Open Mahasiswa List Page', () => {
    it('Index Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get('h2').should('have.text','JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG');
    });
    it('Create Mahasiswa', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get('.btn-success').click();
        cy.get(':nth-child(2) > label').should('have.text','Nim');
        cy.get(':nth-child(3) > label').should('have.text','Nama');
        cy.get(':nth-child(4) > label').should('have.text','Email');
        cy.get(':nth-child(5) > label').should('have.text','Jenis Kelamin');
        cy.get(':nth-child(6) > label').should('have.text','Tanggal Lahir');
        cy.get(':nth-child(7) > label').should('have.text','Alamat');
        cy.get(':nth-child(8) > label').should('have.text','Kelas');
        cy.get(':nth-child(9) > label').should('have.text','Jurusan');
        cy.get(':nth-child(10) > label').should('have.text','Foto');
        cy.get('#Nim').type("20417281",{force:true});
        cy.get('#Nama').type("Venny Meida",{force:true});
        cy.get('#Email').type("venny@gmail.com",{force:true});
        cy.get('#JenisKelamin').type("Perempuan",{force:true});
        cy.get('#TanggalLahir').type('2001-03-02',{force:true});
        cy.get('#Alamat').type("Singosari, Malang",{force:true});
        cy.get('.btn').contains("Submit").and("be.enabled");
    });
    it('Show Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        //show mahasiswa
        cy.get(':nth-child(10) > .btn-info').click();
        cy.get('.card-header').contains('Detail Mahasiswa').and('be.visible');
        cy.get('.list-group > :nth-child(1)').contains('Nim: 20317281').and('be.visible');
        cy.get('.list-group > :nth-child(2)').contains('Nama: Venny Hersianty').and('be.visible');
        cy.get('.list-group > :nth-child(3)').contains('Email: vennyh@gmail.com').and('be.visible');
        //button kembali
        cy.get('.btn').click();
    });
    it('Edit Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        //edit mahasiswa
        cy.get(':nth-child(10) > .btn-primary').click();
        cy.get('.card-header').contains('Edit Mahasiswa').and('be.visible');
        cy.get(':nth-child(3) > label').should('have.text','Nim');
        cy.get(':nth-child(4) > label').should('have.text','Nama');
        cy.get(':nth-child(5) > label').should('have.text','Email');
        cy.get(':nth-child(6) > label').should('have.text','Jenis Kelamin');
        cy.get(':nth-child(7) > label').should('have.text','Tanggal Lahir');
        cy.get(':nth-child(8) > label').should('have.text','Alamat');
        cy.get(':nth-child(9) > label').should('have.text','Kelas');
        cy.get(':nth-child(10) > label').should('have.text','Jurusan');
        cy.get(':nth-child(11) > label').should('have.text','Foto');
        cy.get('#Nim').type("20417281",{force:true});
        cy.get('#Nama').type("Venny Meida",{force:true});
        cy.get('#Email').type("venny@gmail.com",{force:true});
        cy.get('#JenisKelamin').type("Perempuan",{force:true});
        cy.get('#TanggalLahir').type('2001-03-02',{force:true});
        cy.get('#Alamat').type("Singosari, Malang",{force:true});
        cy.get('.btn').contains("Submit").and("be.enabled");
    });
    it('Delete Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        //delete mahasiswa
        cy.get(':nth-child(10) > .btn-danger').click();
    });


})