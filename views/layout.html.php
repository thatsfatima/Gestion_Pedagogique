<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>École supérieur de code 221</title>
    <meta name="description" content="">

    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://ecole221.com/wp-content/uploads/2022/11/cropped-forslide-32x32.png" sizes="32x32">
    <link rel="icon" href="https://ecole221.com/wp-content/uploads/2022/11/cropped-forslide-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="https://ecole221.com/wp-content/uploads/2022/11/cropped-forslide-180x180.png">
    <style>
    </style>
</head>
<style>
body {
    font-family: 'regencie', sans-serif;
    font-weight: bold;
}
</style>
<body class="bg-gradient-to-r from-[#CAE9E3] to-[#AFD7D0] min-h-screen flex flex-col">

  <!--Header-->
  <div class="flex-1 pl-64 pr-0 w-full mb-5">
    <header class="bg-white p-4 flex justify-between items-center shadow-xl rounded-l-2xl">
      <div class="flex items-center">
          <i class="fas fa-laptop-code text-4xl font-bold pl-6 text-[#055812]"></i>
          <span class="font-bold pl-3 text-xl">École 221</span>
      </div>
      <img aria-hidden="true" alt="profile-picture" src="https://placehold.co/40x40" class="rounded-full w-16" />
    </header>
  </div>
  
  <!-- Sidebar -->
  <div class="flex">
    <div class="w-64 rounded-xl ml-4 bg-[#F5B8B6] mt-1 h-[70vh] px-5 flex flex-col justify-between">
      <div>
        <div class="flex justify-between p-1 pt-4 pb-3">
            <button class="bold">
                <i class="fa-solid fa-chalkboard-user text-3xl text-[#055812]"></i>
            </button>
            <button class="bold">
                <i class="bi bi-arrow-right-circle font-bold text-3xl text-[#C0FFBE]"></i>
            </button>
        </div>
        <h1 class="text-2xl font-bold mt-1 pt-2">Teacher</h1>
        <ul class="mt-16 space-y-12">
          <li><a href="/" class="flex text-xl hover:text-green-700">
                <img class="pr-2 " aria-hidden="true" alt="courses-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📚" />
              Cours</a></li>
          <li><a href="#" class="flex text-xl hover:text-green-700">
                <img class="pr-2 " aria-hidden="true" alt="session-icon" src="https://openui.fly.dev/openui/24x24.svg?text=🗓️" />
              Session de cours</a></li>
        </ul>
      </div>
      <button id="buttonaddClient" class="flex items-center justify-center mb-9">
        <span class="text-white text-xl pr-6 font-black  hover:text-[#d9f5b]">
          Log Out</span>
        <i class="fa-solid fa-power-off text-4xl text-[#055812] "></i>
      </button>
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