<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
  <?php
  require_once('navbar-generator/navbar.php');
  ?>
  <div class="container mt-4">
    <div class="col-sm-8">
      <?php
      require_once('form-generator.php');
      require_once('css-generator/add-new-css.php');
      $fields = array(
        array(
          'type' => 'text',
          'name' => 'nom',
          'label' => 'Votre nom :',
          'css_class' => 'form-control',
          'div_wrapper' => 'form-group',
          'placeholder' => 'Entrez votre nom',
          'required' => true,
        ),
        array(
          'type' => 'password',
          'name' => 'password',
          'label' => 'Votre password :',
          'css_class' => 'form-control',
          'div_wrapper' => 'form-group',
          'placeholder' => 'Entrez votre password',
          'required' => true,
        ),
        array(
          'type' => 'email',
          'name' => 'email',
          'label' => 'Votre email :',
          'css_class' => 'form-control',
          'div_wrapper' => 'form-group',
          'placeholder' => 'Entrez votre email',
          'required' => true,
        ),
        array(
          'type' => 'select',
          'name' => 'sujet',
          'label' => 'Sujet :',
          'css_class' => 'form-control',
          'div_wrapper' => 'form-group',
          'options' => array(
            '1' => 'Question sur le produit',
            '2' => 'Suggestion',
            '3' => 'Réclamation',
          ),
          'required' => true,
        ),
        array(
          'type' => 'textarea',
          'name' => 'message',
          'label' => 'Votre message :',
          'css_class' => 'form-control',
          'div_wrapper' => 'form-group',
          'placeholder' => 'Entrez votre message',
          'required' => true,
        ),
        array(
          'type' => 'button',
          'name' => 'send',
          'value' => 'Envoyer',
          'css_class' => 'btn btn-primary mt-2',
          'div_wrapper' => 'form-group',
        ),
      );

      $form = new FormGenerator($fields, 'POST', 'traitement/test.php');
      echo $form->getForm();
      ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>