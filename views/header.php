<!DOCTYPE html>
<html>
  <!--
    WARNING! Make sure that you match all Quasar related
    tags to the same version! (Below it's "@2.6.6")
  -->

  <head>
    <title><?=$this->title?></title>

    <?php 
      if (isset($this->js)) 
      {
          foreach ($this->js as $js)
          {
              echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
          }
      }
    ?>

    <?php 
      if (isset($this->css)) 
      {
          foreach ($this->css as $css)
          {
              echo '<link href="'.URL.'views/'.$css.'" rel="stylesheet" type="text/css">';
          }
      }
    ?>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/quasar.prod.css" rel="stylesheet" type="text/css">
  </head>

  <body>
    <!-- example of injection point where you write your app template -->
    <div id="q-app">
      <q-layout view="hHh lpR fFf">
        <q-header elevated class="text-white" height-hint="98" style="background-color: #3e65a0;">
          <q-toolbar>
            <q-toolbar-title>
              
                <img src="https://oficial.unimar.br/wp-content/themes/unimarpresencial/images/logo.svg" style="height: 30px; width: auto; margin-bottom: 0px;">
             
            </q-toolbar-title>
          </q-toolbar>

          <q-tabs align="left">
            <q-route-tab href="<?=URL?>professor" label="Professores"></q-route-tab>
            <q-route-tab href="<?=URL?>classecurso" label="Classes de Cursos"></q-route-tab>
          </q-tabs>
        </q-header>

        <q-page-container> 
          <custom-button></custom-button>
          <router-view />
        </q-page-container>

      </q-layout>
    </div>

    <!-- Add the following at the end of your body tag -->
    <script src="<?=URL;?>public/js/axios.min.js"></script>
    <script src="<?=URL;?>public/js/libs.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/quasar.umd.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/lang/pt-BR.umd.prod.js"></script>
    
    <script>
      /*
        Example kicking off the UI. Obviously, adapt this to your specific needs.
        Assumes you have a <div id="q-app"></div> in your <body> aboveaaa
       */
      
      const app = Vue.createApp({
        data: function () {
            return {
            }
        },
        components: {
            'custom-button': CustomButton,
        },
      })

      app.use(Quasar)
      Quasar.lang.set(Quasar.lang.ptBR)
      app.mount('#q-app')

    </script>
  </body>
</html>
