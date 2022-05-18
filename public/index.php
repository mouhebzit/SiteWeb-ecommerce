<?php

require_once('../private/initialize.php');



if(is_post_request()) {

  $user['first_name'] = $_POST['first_name'] ?? '';
  $user['last_name'] = $_POST['last_name'] ?? '';
  $user['email'] = $_POST['email'] ?? '';
  $user['username'] = $_POST['username'] ?? '';
  $user['password'] = $_POST['password'] ?? '';
  /*$user['confirm_password'] = $_POST['confirm_password'] ?? '';*/

  $result = insert_user($user);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'user created.';
    $user['id']=$new_id;
    log_in_user($user);
    /*redirect_to(url_for('index.php?id=' . $new_id));*/
    redirect_to(url_for('index.php'));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $user = [];
  $user["first_name"] = '';
  $user["last_name"] = '';
  $user["email"] = '';
  $user["username"] = '';
  $user['password'] = '';
  $user['confirm_password'] = '';

} 

?>





<!DOCTYPE html>
<html id="html-id"  dir="ltr" lang="fr-FR">
    <head>
        <meta charset="utf-8" />
        <title>Marybé</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
     
     

     <header id="header-bar">

        <div class="title-bar">
          <h4 class="livraison">LIEU DE LIVRAISON: <strong>TN D</strong></h4>  
          <h1 class="Marybe">MARYBÈ </h1>
          <div class="icons">
            <a href="javascript:void(0)" onclick="openNav(); on();"><i style="font-size:20px" class="fa">&#xf2c0;</i></a>
            <a href=""><i style="font-size:20px" class="fa"> &#xf006;</i></a>
          </div>
       </div>
        <div>
            <ul class="nav-bar" id="nav-bar-hide">
                <li><a href='#'>NOS PORDUITS</a></li>
                <li><a href='#'>TENDANCES</a></li>
                <li><a href='#'>MESSAGES</a></li>
            </ul>
        </div>

     </header>

     <nav>
        <div id="mySidepanel" class="sidepanel">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav(); off();">×</a>
           <ul class="account-bar">
             <li><a href="javascript:void(0)" id='inscription-button' onclick="inscri()">INSCRIPTION</a></li>
             <li><a href="javascript:void(0)" id='compte-button' onclick="sign_in()">COMPTE</a></li>
             <li><a href='#'>FAVORIS</a></li>
           </ul>
           
           <div style="position:absolute; left: 0;">
             <?php echo display_errors($errors); ?> 
          </div>   

           <section>
            
            <div class="login" id="login-container">
                <?php if (!is_logged_in()) : ?>
            <p class="se-con">SE CONNECTER</p>
            <p class="acced">Pour accéder à votre compte</p>
            
            <form>
              <label class="email-" for="email"><sup>*</sup>E-mail</label>
              <input class="input-design show-on-focus" type="email" name="email" id="email" required="" placeholder="me@marybe.fr">
              <label for="pass" class="password-"><sup>*</sup>Mot de passe</label>
              <input class="input-design" type="password" id="pass" name="password"minlength="8" required>
              <a href="#" class="reset-pass">Mot de passe oublié ?</a>
              <button class="button-submit" type="submit">
                ME CONNECTER
              </button>
            </form>
            <div class="sign-nav">
                <p class="vous-nav">VOUS N'AVEZ PAS DE COMPTE ?</p>
                <button class="button-create" onclick="inscri()" >CRÉER UN COMPTE</button>
            </div>
            <?php endif; ?>
            <?php if (is_logged_in()) : ?>

              <p class="welcome"> Bienvenu <?php echo $_SESSION['full_name'] ; ?> 
              <a class="log_out" href="<?php echo url_for('/staff/logout.php'); ?>">SE DECONNECTER</a>

            <?php endif; ?>
           </div> 
           
            
          

         </section>






         <section>
         
           <div class="sign-up" id="signup-container">
            <p class="cre-compte">CRÉER UN COMPTE</p>
            <p class="rejoignez">Rejoignez-nous sur Marybé.fr</p>
            <form action="<?php echo url_for('index.php'); ?>" method="post">


              <label for="civilite_input"></label>
              <select name="civilite" id="civilite_input" class="input-select-design-inscri" type="select" required>
                <option disabled selected>Civilité</option>
                <option>M.</option>
                <option>Mme</option>
              </select>




              <label for="name_input" class="name_input_">Prénom<sup>*</sup></label>
              <input class="input-design-inscri" type="text" placeholder="" name="first_name" id="name_input" required value="<?php echo h($user['first_name']); ?>">


              <label for="lastname_input" class="lastname_input_">Nom<sup>*</sup></label>
              <input class="input-design-inscri" type="text" placeholder="" name="last_name" id="lastname_input" required value="<?php echo h($user['last_name']); ?>">


              <label for="pays_input" class="pays_input_">Tunisie</label>
              <input class="input-design-inscri" type="text" placeholder="" name="country" id="pays_input" disabled>




              <label class="email-inscri" for="email_ins">E-mail<sup>*</sup></label>
              <input class="input-design-inscri show-on-focus" type="email" name="email" id="email_ins" required="" placeholder="me@marybe.fr" value="<?php echo h($user['email']); ?>">


              <label for="pass_ins" class="password-inscri">Mot de passe<sup>*</sup></label>
              <input class="input-design-inscri" type="password" id="pass_ins" name="password" minlength="8" required value="">


              


              <button class="button-submit-cree" type="submit" >
                CRÉER UN COMPTE
              </button>
            </form>
           </div> 

         </section>






       </div> 
       <div id="overlay" onclick="off(); closeNav(); "></div>
     <script>
        function openNav() {
          document.getElementById("mySidepanel").style.width = "550px";
         }

         function closeNav() {
           document.getElementById("mySidepanel").style.width = "0";
          }
          function on() {
           document.getElementById("overlay").style.display = "block";
          }

          function off() {
           document.getElementById("overlay").style.display = "none";
          }

          function inscri() {
           var x = document.getElementById("login-container");
           /*if (x.style.display === "none") {
             x.style.display = "flex";
            } else {
                x.style.display = "none";
           }*/
           x.style.display = "none";
           document.getElementById("signup-container").style.display = "flex";
           document.getElementById("inscription-button").style.borderBottom =  ".125rem solid black";
           document.getElementById("compte-button").style.borderBottom =  "none";
           }

           function sign_in () {
            document.getElementById("login-container").style.display = "flex";
            document.getElementById("signup-container").style.display = "none";
            document.getElementById("inscription-button").style.borderBottom =  "none";
            document.getElementById("compte-button").style.borderBottom =  ".125rem solid black";
           }
           
           

           var prevScrollpos = window.pageYOffset;
           var height = document.body.offsetHeight;
           window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (currentScrollPos > 1000) {
    
              document.getElementById("header-bar").style.zIndex = "0";
              /*document.getElementById("header-bar").style.animation = " fadein 2s ease-in  ";*/
               }

            else {
             document.getElementById("header-bar").style.zIndex = "2";

             }

             prevScrollpos = currentScrollPos;
            }


      </script>
    </nav>


    <main>
     <section class="diapo-container">
      <div class="slider">
        <div class="slides">
            <input type="radio" name="radio-btn" id="radio1">
            <input type="radio" name="radio-btn" id="radio2">
            <input type="radio" name="radio-btn" id="radio3">
            <input type="radio" name="radio-btn" id="radio4">

            <div class="slide first">
                <img src="images/1.jpg">
            </div>
            <div class="slide">
                <img src="images/2.jpg">
            </div>
            <div class="slide">
                <img src="images/3.jpg">
            </div>
            <div class="slide">
                <img src="images/4.jpg">
            </div>

            <div class="navigation-manual">
              <label for="radio1" class="manual-btn1"></label>
              <label for="radio2" class="manual-btn2"></label>
              <label for="radio3" class="manual-btn3"></label>
              <label for="radio4" class="manual-btn4"></label>
            </div>
            
        </div>

        
          
      </div>
      <script type="text/javascript">
          var counter = 1;
          setInterval(function(){
            document.getElementById('radio' + counter).checked = true;
            counter++;
            if (counter > 4) {
                counter = 1;
            }
          }, 3000);



      </script>
     </section>






     <section>
      <div class="row">

        <div class="column">
           <img src="images/11.jpeg" alt="Snow" style="width:100%;height:100%;">
        </div>

        <div class="column">
            <img src="images/22.jpeg" alt="Forest" style="width:100%; height:100%;">
        </div>

        <div class="column">
           <img src="images/33.jpeg" alt="Mountains" style="width:100%; height: 100%;">
        </div>
     </div>
    </section>



     </main>

     <footer>
         <div class="footer-title">
           <h1 class="Marybe-blanc">MARYBÈ</h1>
         </div>

         <div class="nav-container-footer">
             <section class="heading-titles">
                 <p>SERVICES EN LIGNE</p>
                 <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Livraison</a></li>
                    <li><a href="#">Paiements</a></li>
                    <li><a href="#">Contact</a></li>
                 </ul>
             </section>



             <section class="heading-titles">
                  <p>À PROPOS</p>
                  <ul>
                    <li><a href="#">Qui-Sommes-Nous?</a></li>
                  </ul>
             </section>



             <section class="heading-titles">
                  <p>MENTIONS LÉGALES</p>
                  <ul>
                      <li><a href="#">Politique de confidentialité</a></li>
                      <li><a href="#">Politique relative aux cookies</a></li>
                      <li><a href="#">Conditions générales de vente</a></li>
                      <li><a href="#">Conditions générales d'utilisation</a></li>
                  </ul>
             </section>


         </div>

         <div class="contact-us">
             <ul>
                 <li>
                    <a href="https://www.instagram.com/marybe_paris/">
                        <img src="images/instagram.png">
                    </a>

                 </li>
                 <li>
                    <a href="#">
                        <img src="images/facebook.png">
                    </a>
                </li>
             </ul>
         </div>


     </footer>

    </body>
</html> 