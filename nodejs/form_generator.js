class FormGenerator {
  constructor(action, method, enctype, id, fields) {
    this.action = action;
    this.method = method;
    this.enctype = enctype;
    this.fields = fields;
    this.id = id;
  }

  getField(field){
    switch (field.type) {
      case 'text':
      case 'email':
      case 'password':
      case 'number':
      case 'tel':
      case 'hidden':
      case 'submit':
        return this.createInputField(field);
        break;
      case 'select':
        return this.createSelectField(field);
        break;
      case 'textarea':
        return this.createTextareaField(field);
        break;
      case 'button':
        return this.createButtonField(field);
        break;
      case 'radio':
        return this.createRadioField(field);
        break;
      case 'checkbox':
        return this.createCheckboxField(field);
        break;
      case 'color':
        return this.createColorField(field);
        break;
      case 'file':
        return this.createFileField(field);
        break;
      case 'date':
        return this.createDateField(field);
        break;
      case 'repearfield':
        return this.repeatFields(field);
        break;
      case 'repearbutton':
        return this.repeatButton(field.fields);
        break;
      default: ''
        break;
    }
  }

  createForm() {
    let form = `<form id="${this.id}" action="${this.action}" method="${this.method}" enctype="${this.enctype}">\n`;

    this.fields.forEach((field) => {
      let fieldHtml = '';
      fieldHtml = this.getField(field);

      form += `<div `;
      if (field.css_div) {
        form += ` style="${field.css_div}"`;
      } else if (field.id_div) {
        form += ` id="${field.id_div}"`;
      } else if (field.class) {
        form += ` class="${field.class}"`;
      } else {
      }
      form += ` >`;

      if (field.label) {
        if((field.type !== 'submit') && (field.type !== 'button')){
          form += `<label`;
          if(field.label_css){
            form += ` style="${field.css_label}" `;
          }
          if(field.label_class){
            form += ` style="${field.label_class}" `;
          }
          if(field.label_id){
            form += ` style="${field.label_id}" `;
          }
          form += `>\n${field.label}\n</label>\n`;
        }
      }


      form += ` \n${fieldHtml}\n</div>\n`;
    });

    form += '</form>';
    return form;
  }

  createInputField(field) {
    let fieldHtml = `<input`;
    Object.keys(field).forEach((attribute) => {
      fieldHtml += ` ${attribute}="${field[attribute]}"`;
    });
    fieldHtml += '>';
    return fieldHtml;
  }


  repeatFields(fields) {
    let html = '';
    let fieldHtml = '';
    fields.field.forEach((field) => {
      switch (field.type) {
        case 'text':
        case 'email':
        case 'password':
        case 'number':
        case 'tel':
          fieldHtml += this.createInputField(field);
          break;
        case 'select':
          fieldHtml += this.createSelectField(field);
          break;
        case 'textarea':
          fieldHtml += this.createTextareaField(field);
          break;
        case 'button':
          fieldHtml += this.createButtonField(field);
          break;
        case 'radio':
          fieldHtml += this.createRadioField(field);
          break;
        case 'checkbox':
          fieldHtml += this.createCheckboxField(field);
          break;
        case 'color':
          fieldHtml += this.createColorField(field);
          break;
        case 'file':
          fieldHtml += this.createFileField(field);
          break;
        case 'date':
          fieldHtml += this.createDateField(field);
          break;
      }
    });

    html += `<div style="${fields.id}">\n${fieldHtml}\n</div>\n`;
    return html;
  }

  repeatButton(fields) {
    let repeatButton = this.createButtonField({
      type: 'button',
      value: 'Répéter les champs',
      action: () => {
        let html = this.repeatFields(fields);
        // insérer le code HTML des champs répétés dans le formulaire
      }
    });
    return repeatButton;
  }

  createSelectField(field) {
    let fieldHtml = `<select`;
    Object.keys(field).forEach((attribute) => {
      if (attribute !== 'type' && attribute !== 'options') {
        fieldHtml += ` ${attribute}="${field[attribute]}"`;
      }
    });
    fieldHtml += '>\n';
    field.options.forEach((option) => {
      fieldHtml += `<option value="${option.value}">${option.label}</option>\n`;
    });
    fieldHtml += '</select>';
    return fieldHtml;
  }

  createTextareaField(field) {
    let fieldHtml = `<textarea`;
    Object.keys(field).forEach((attribute) => {
      if (attribute !== 'type') {
        fieldHtml += ` ${attribute}="${field[attribute]}"`;
      }
    });
    fieldHtml += '></textarea>';
    return fieldHtml;
  }

  createButtonField(field) {
    let fieldHtml = `<button`;
    Object.keys(field).forEach((attribute) => {
      if ((attribute !== 'type') && (attribute !== 'input_type')) {
        fieldHtml += ` ${attribute}="${field[attribute]}"`;
      }
    });
    if(! field.label){
      field.label = field.value;
    }
    fieldHtml += `>${field.label}</button>`;
    return fieldHtml;
  }

  createRadioField(field) {
    let fieldHtml = '';
    field.options.forEach((option) => {
      fieldHtml += `<input type="radio" name="${field.name}" value="${option.value}"`;
      if (field.required) {
        fieldHtml += ' required';
      }
      if (field.disabled) {
        fieldHtml += ' disabled';
      }
      if (field.css) {
        fieldHtml += ` style="${field.css}"`;
      }
      if (field.class) {
        fieldHtml += ` class="${field.class}"`
      }
      if (field.id) {
        fieldHtml += ` id="${field.id}"`;
      }
      fieldHtml += `>${option.label}<br>`;
    });
    return fieldHtml;
  }

  createCheckboxField(field) {
    let fieldHtml = '';
    field.options.forEach((option) => {
      fieldHtml += `<input type="checkbox" name="${field.name}" value="${option.value}"`;
      if (field.required) {
        fieldHtml += ' required';
      }
      if (field.disabled) {
        fieldHtml += ' disabled';
      }
      if (field.css) {
        fieldHtml += ` style="${field.css}"`;
      }
      if (field.class) {
        fieldHtml += ` class="${field.class}"`;
      }
      if (field.id) {
        fieldHtml += ` id="${field.id}"`;
      }
      fieldHtml += `>${option.label}<br>`;
    });
    return fieldHtml;
  }

  createColorField(field) {
    let fieldHtml = `<input type="color"`;
    if (field.required) {
      fieldHtml += ' required';
    }
    if (field.disabled) {
      fieldHtml += ' disabled';
    }
    if (field.css) {
      fieldHtml += ` style="${field.css}"`;
    }
    if (field.class) {
      fieldHtml += ` class="${field.class}"`;
    }
    if (field.id) {
      fieldHtml += ` id="${field.id}"`;
    }
    fieldHtml += '>';
    return fieldHtml;
  }

  createFileField(field) {
    let fieldHtml = `<input type="file"`;
    if (field.required) {
      fieldHtml += ' required';
    }
    if (field.disabled) {
      fieldHtml += ' disabled';
    }
    if (field.css) {
      fieldHtml += ` style="${field.css}"`;
    }
    if (field.class) {
      fieldHtml += ` class="${field.class}"`;
    }
    if (field.id) {
      fieldHtml += ` id="${field.id}"`;
    }
    fieldHtml += '>';
    return fieldHtml;
  }

  createDateField(field) {
    let fieldHtml = `<input type="date"`;
    if (field.required) {
      fieldHtml += ' required';
    }
    if (field.disabled) {
      fieldHtml += ' disabled';
    }
    if (field.css) {
      fieldHtml += ` style="${field.css}"`;
    }
    if (field.class) {
      fieldHtml += ` class="${field.class}"`;
    }
    if (field.id) {
      fieldHtml += ` id="${field.id}"`;
    }
    fieldHtml += '>';
    return fieldHtml;
  }
}
module.exports = FormGenerator;