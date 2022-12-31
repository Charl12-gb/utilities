const express = require('express');
const app = express();
const FormGenerator = require('./form_generator');

// Définition du moteur d'affichage ejs
app.set("view engine", "ejs");
app.set("views", "IHM");

app.get('/', (request, response) => {

    const repeatfield = [
        {
            type: 'text',
            name: 'username',
            placeholder: 'Username',
            css: 'width: 100%',
            class: 'form-field'
        },
        {
            type: 'password',
            name: 'password',
            placeholder: 'PassWord',
            required: true,
            css: 'width: 100%',
            class: 'form-field'
        },
        {
            type: 'select',
            name: 'country',
            id: 'country',
            css: 'width: 100%',
            class: 'form-field',
            options: [{
                    value: 'france',
                    label: 'France'
                },
                {
                    value: 'germany',
                    label: 'Germany'
                },
                {
                    value: 'italy',
                    label: 'Italy'
                }
            ]
        },
        {
            type: 'textarea',
            name: 'message',
            id: 'message',
            placeholder: 'Enter your message here',
            css: 'width: 100%',
            rows: 5,
            class: 'form-field'
        },
    ];

    let container = '';//document.getElementById('form-container');

    const fields = [
        {
            type: 'text',
            name: 'username',
            placeholder: 'Username',
            css: 'width: 100%',
            class: 'form-field'
        },
        {
            type: 'password',
            name: 'password',
            placeholder: 'PassWord',
            required: true,
            css: 'width: 100%',
            class: 'form-field'
        },
        {
            type: 'select',
            name: 'country',
            css: 'width: 100%',
            class: 'form-field',
            options: [{
                    value: 'france',
                    label: 'France'
                },
                {
                    value: 'germany',
                    label: 'Germany'
                },
                {
                    value: 'italy',
                    label: 'Italy'
                }
            ]
        },
        {
            type: 'textarea',
            name: 'message',
            placeholder: 'Enter your message here',
            css: 'width: 100%',
            rows: 5,
            class: 'form-field'
        },
        {
            type: 'radio',
            name: 'gender',
            required: true,
            options: [{
                    value: 'male',
                    label: 'Male'
                },
                {
                    value: 'female',
                    label: 'Female'
                }
            ],
            class: 'form-field'
        },
        {
            type: 'checkbox',
            name: 'hobbies',
            required: true,
            options: [{
                    value: 'reading',
                    label: 'Reading'
                },
                {
                    value: 'traveling',
                    label: 'Traveling'
                },
                {
                    value: 'cooking',
                    label: 'Cooking'
                }
            ],
            class: 'form-field'
        },
        {
            type: 'color',
            name: 'color',
            required: true,
            class: 'form-field'
        },
        {
            type: 'file',
            name: 'resume',
            required: true,
            class: 'form-field'
        },
        {
            type: 'date',
            name: 'date',
            required: false,
            class: 'form-field'
        },
        {
            type: 'repearfield',
            id: 'form-container',
            field: repeatfield
        },
        {
            type: 'repearbutton',
            fields: repeatfield
        },
        {
            type: 'button',
            label: 'Send',
            css: 'width: 100%',
            class: 'form-field'
        }
    ];

    const formGenerator = new FormGenerator('/submit', 'POST', 'multipart/form-data', 'form12', fields);
    const formHtml = formGenerator.createForm();
    response.status(200).render('index', { form: formHtml});
});

app.listen(3000, () => {
    console.log('Server listening on port 3000');
});
