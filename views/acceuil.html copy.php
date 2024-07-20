<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.cdnfonts.com/css/regencie" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="icon" href="icon.png" sizes="80x40" type="image/png">
  <title>Mamy Boutique</title>
<style>
body {
    font-family: 'Regencie', sans-serif;
    font-weight: bold;
}

</style>
<body class="bg-gradient-to-r from-[#CAE9E3] to-[#AFD7D0] min-h-screen flex flex-col">
  <!--Header-->
  <div class="flex-1 pl-64 pr-0 w-full">
    <header class="bg-white p-4 flex justify-between items-center shadow-xl rounded-l-full">
        <div class="flex items-center">
            <i class="bi bi-cart2 text-3xl font-bold pl-6 text-[#889922]"></i>
            <span class="font-bold pl-2 text-xl">Mamy</span>
        </div>
        <div class="flex items-center ml-[-10%]">
            <i class="bi bi-bag text-3xl font-bold text-[#889922]"></i>
            <span class="font-bold pl-2 text-xl"></span>
        </div>
        <button id="buttonaddClient" class="text-[#6BC168] hover:text-[#BAFFB7] flex items-center justify-around w-[7%]">
            <i class="fa-solid fa-right-from-bracket text-xl text-[#F87773] hover:text-[#F5B8B6]"></i>
            Log Out</button>
    </header>
  </div>
  
  <!-- Sidebar -->
  <div class="flex">
    <div class="w-64 rounded-xl ml-4 bg-[#F5B8B6] mt-[-2.5%] h-[80vh] px-5">
        <div class="flex justify-between p-1 pt-4 pb-3">
            <button class="bold">
                <i class="fa-solid fa-bars text-2xl text-[#416454]"></i>
            </button>
            <button class="bold">
                <i class="bi bi-arrow-right-circle font-bold text-3xl text-[#C0FFBE]"></i>
            </button>
        </div>
      <h1 class="text-2xl font-bold mb-6 pt-2">Boutiquier</h1>
      <ul class="space-y-4">
        <li><a href="/" class="block hover:text-green-700">
            <i class="fa-solid fa-store text-[#6BC168] text-xl font-extrabold pr-2 "></i>
            Dashboard</a></li>
        <li><a href="#" class="block hover:text-green-700">
            <i class="fa-solid fa-hand-holding-dollar text-[#6BC168] text-2xl font-extrabold pr-2 "></i>
            Liste des clients</a></li>
        <li><a href="#" class="block hover:text-green-700">
            <i class="fa-solid fa-tags text-[#6BC168] text-2xl font-extrabold pr-2 "></i>
            Articles</a></li>
        <li><a href="#" class="block hover:text-green-700">
            <i class="fa-solid fa-cash-register text-[#6BC168] text-2xl font-extrabold pr-2 "></i>
            Vendeurs</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 pb-0 m-6 bg-[#F1FEF2] h-[80vh] rounded-xl  shadow-2xl">
      <!-- Nouveau Client Form -->
      <div class="flex space-x-10">
        <div class="bg-[#537E6A] p-5 rounded-lg shadow-md w-1/2 h-1/2">
          <div class="flex justify-between pb-4">
            <div class="flex space-x-6 items-center">
              <label class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center" for="photo">
                <img  id='this_img' src="<?= !empty($_POST['photo']) ? $_POST['photo'] : 'https://via.placeholder.com/50' ?>" class="w-full h-full rounded-full">
              </label>
              <label class="block text-white mb-2 flex flex-col" for="photo">Selectionnez une photo
            <span class="text-[#F5DBDA] text-sm font-bold">
              <?php if (isset($_SESSION['errors']['photo'])) { echo $_SESSION['errors']['photo']; } ?>
            </span></label>
            </div>
            <h2 class="text-xl font-bold text-white mb-4">Nouveau Client</h2>
          </div>
          
          <form action="/client/add" method="post" enctype="multipart/form-data">
            <div class="flex space-x-4">
              <div class="flex flex-col space-y-4 w-[90%]">
                <label class="block text-white" for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="w-full px-3 py-2 rounded" placeholder="Nom"
                  value="<?php if (isset($_SESSION['fields']['nom'])) { echo $_SESSION['fields']['nom']; } ?>">
                <span class="text-[#F5DBDA] text-sm font-bold">
                  <?php if (isset($_SESSION['errors']['nom'])) { echo $_SESSION['errors']['nom'].""; } ?>
                </span>
              </div>
              <div class="flex flex-col space-y-4 w-[90%]">
                <label class="block text-white" for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom" class="w-full px-3 py-2 rounded" placeholder="Prenom"
                  value="<?php if (isset($_SESSION['fields']['prenom'])) { echo $_SESSION['fields']['prenom']; } ?>">
                <span class="text-[#F5DBDA] text-sm font-bold">
                  <?php if (isset($_SESSION['errors']['prenom'])) { echo $_SESSION['errors']['prenom']; } ?>
                </span>              
              </div>
            </div>
            <div class="flex space-x-4">
              <div class="flex flex-col space-y-4 w-[90%]">
                <label class="block text-white" for="email">Email</label>
                <input type="text" name="email" id="email" class="w-full px-3 py-2 rounded" placeholder="Email"
                  value="<?php if (isset($_SESSION['fields']['email']) && empty($_SESSION['errors']['email']) && empty($_SESSION['errors']['email2'])) { echo $_SESSION['fields']['email']; } ?>">
                <span class="text-[#F5DBDA] text-sm font-bold">
                  <?php if (isset($_SESSION['errors']['email'])) { echo $_SESSION['errors']['email'].""; }
                       if (isset($_SESSION['errors']['email2']) && empty($_SESSION['errors']['email'])) { echo $_SESSION['errors']['email2'];} ?>
                </span>
              </div>
              <div class="flex flex-col space-y-4 w-[90%]">
                <label class="block text-white" for="tel">Tel</label>
                <input type="tel" name="tel" id="tel" class="w-full px-3 py-2 rounded" placeholder="Tel"
                  value="<?php if (isset($_SESSION['fields']['tel']) && empty($_SESSION['errors']['telephone2']) && empty($_SESSION['errors']['telephone'])) { echo $_SESSION['fields']['tel']; } ?>">
                  <span class="text-[#F5DBDA] text-sm font-bold">
                    <?php if (isset($_SESSION['errors']['tel'])) { echo $_SESSION['errors']['tel']; }
                         if (isset($_SESSION['errors']['telephone']) && empty($_SESSION['errors']['tel'])) { echo $_SESSION['errors']['telephone'];} ?>
                </span>
              </div>
            </div>
            <div class="pl-24 flex space-x-2 justify-evently items-center">
                <input type="file" onchange="loadFile(event)"  name="photo" id="photo" class="w-2/3 px-3 py-2 rounded" hidden>
            </div>
            <div class="flex justify-center mt-8">
                <button type="submit" class="w-1/4 bg-[#F5B8B6] text-white font-bold py-2 rounded-full shadow-lg border border-[#0085FF] hover:border-[#F5B8B6]">Enregistrer</button>
            </div>
          </form>
        </div>

        <!-- Suivie Dette Section -->
        <div class="w-1/2 p-6 pt-2 rounded-lg shadow-md mb-4 h-[70vh]">
          <div class="">
            <h2 class="text-4xl text-center font-bold text-[#6BC168] mb-4">Suivie Dette</h2>
            <span class="text-red-400 text-sm font-bold"><?php if ((isset($errors["telSuivi"]))) {echo $errors["telSuivi"]; }?></span>
            <form method="post" action="/client/search" class="flex items-center mb-4">
              <label class="block text-green-900 mr-2" for="telSuivi">Tel</label>
              <input type="text" value="<?php if (isset($_POST['telSuivi'])) { echo $_POST['telSuivi']; }?>" id="telSuivi" name="telSuivi" class="flex-1 px-3 py-2 rounded mr-2" placeholder="telSuivi">
              <button class="bg-green-800 text-white px-4 py-2 rounded">OK</button>
            </form>
            <div class="flex space-x-2 mb-4 text-green-900">
              <form action="../" method="post" class="w-full">
                <input type="hidden" name="idClient" value="[164.312px]">
                <button href="../" class="w-full flex-1 bg-[#F5B8B6] text-center font-bold py-2 rounded hover:bg-pink-400">Client <i class="fa-solid fa-arrows-rotate"></i></button>
              </form>
              <form action="../dette/add" method="post" class="w-full">
                <input type="hidden" name="idClient" value="<?php if(isset($client->id)) {echo $client->id;} ?>">
                <button class="w-full flex-1 bg-[#F5B8B6] font-bold py-2 rounded hover:bg-pink-400">Nouvelle <i class="fa-solid fa-plus"></i></button>
              </form>
              <form action="../listeDettes" method="post" class="w-full">
                <input type="hidden" name="idClient" value="<?php if(isset($client->id)) {echo $client->id;} ?>">
                <button class="w-full flex-1 text-center bg-[#F5B8B6] font-bold py-2 rounded hover:bg-pink-400">Dettes <i class="fa-regular fa-credit-card"></i></button>
              </form>
            </div>
            <div class="flex items-center mb-10">
              <img src="<?php if(isset($client->photo) && !empty($client->photo)) { echo '/imgClient/'.$client->photo;} else {echo 'https://via.placeholder.com/50';}?>" alt="Client photo" class="w-32 h-32 rounded-full mr-4">
                <div class=" space-y-4 text-[#6BC168]">
                <p class="font-bold">
                  <i class="fa-solid fa-user"></i>
                  <?php  if(isset($client->nom)) { echo $client->nom; } ?></p>
                <p class="text-green-600">
                  <i class="fa-regular fa-envelope"></i>
                  <?php if(isset($client->email)) { echo $client->email; } ?></p>
              </div>
            </div>
          </div>
          <div class="bg-[#537E6A] text-white p-5 rounded-lg shadow-md mt-6">
            <p class="mb-2">Total Dette : <?php if(isset($client->montantDette)) { echo $client->montantDette." XOF"; } ?></p></p>
            <p class="mb-2">Montant Versé : <?php if(isset($client->montantVerse)) { echo $client->montantVerse." XOF"; } ?></p></p>
            <p class="mb-2">Montant Restant : <?php if(isset($client->montantRestant)) { echo $client->montantRestant." XOF"; } ?></p></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
        var loadFile = function (event) {

            var input = event.target;
            var file = input.files[0];
            var type = file.type;

            var output = document.getElementById('this_img');


            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
</body>

</html>