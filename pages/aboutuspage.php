 <?php
  include('./nav.php');
?>
 <!DOCTYPE html>
 <html>

 <head>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="./output.css">
     <style>
     body {
         font-family: Arial, Helvetica, sans-serif;
         margin: 0;
     }

     html {
         box-sizing: border-box;
     }


     *,
     *:before,
     *:after {
         box-sizing: inherit;
     }

     .column {
         float: left;
         width: 33.3%;
         margin-bottom: 16px;
         padding: 0 8px;
     }

     .card {
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
         margin: 8px;
     }

     .about-section {
         padding: 50px;
         text-align: center;
         background-color: #474e5d;
         color: white;
     }

     .column .container {
         display: flex;
         flex-direction: column;
         gap: 10px;
         padding: 8px;

     }


     .row::after {
         content: "";
         clear: both;
         display: table;

     }

     .partnerLogo img {
         width: 100px;
         height: 100px;
     }

     .title {
         color: grey;
     }

     .button {
         border: none;
         outline: 0;
         display: inline-block;
         padding: 8px;
         color: white;
         background-color: #000;
         text-align: center;
         cursor: pointer;
         width: 100%;
     }

     .button:hover {
         background-color: #555;
     }

     @media screen and (max-width: 650px) {
         .column {
             width: 100%;
             display: block;
         }
     }
     </style>
 </head>

 <body>

     <div class="about-section">
         <h2>About Us Page</h2>
         <p>Welcome Our beloved visiter's.</p>
         <p>we hope our site is able to help you as your wants.</p>
     </div>

     <h2 style="text-align:center" class=" text-center font-bold text-3xl my-4">Our Team</h2>
     <div class="row">
         <div class="column">
             <div class="card">
                 <img src="../aboutUs/reea.jpg.jpeg" alt="sanchari" style="width:30%;height:20% ; margin-left: 7%;">
                 <div class="container">
                     <h2>Reea Paul</h2>
                     <p class="title">CEO & Founder</p>
                     <p>Hello,Myself Reea Paul i'm the desingner of this site.also can desing your food as you want so
                         dont worry before using our site</p>
                     <p>reea10@gmail.com</p>
                     <p>Contact Number- 6291649235</p>
                 </div>
             </div>
         </div>

         <div class="column">
             <div class="card">
                 <img src="../aboutUs/poulomi.jpg.jpeg" alt="Reea" style="width:30%;height:20% ; margin-left: 7%;">
                 <div class="container">
                     <h2>Poulomi Barman</h2>
                     <p class="title">Art Director</p>
                     <p>Hello visiters,myself Poulomi Barman.we are here to fulfill your wants just stay connected with
                         us.</p>
                     <p>poulomi7@gmail.com</p>
                     <p>Contact Number- 9874638923</p>
                 </div>
             </div>
         </div>


         <div class="column">
             <div class="card">
                 <img src="../aboutUs/rudra.jpg" alt="Rudra" style="width:39% ;height:33% ; margin-left: 7%;">
                 <div class="container">
                     <h2>Rudra Sarkar</h2>
                     <p class="title">Developer</p>
                     <p>Hello,Everyone myself Rudra Sarkar . if anyone facing any problem just feel free and contact
                         us.Thank You.</p>
                     <p>rudra8@gmail.com</p>
                     <p>Contact Number- 9874532689</p>
                 </div>
             </div>
         </div>
     </div>

     <div class="column">
         <div class="card">
             <img src="../aboutUs/keya.jpg.jpeg" alt="Keya" style="width:40%;height:20% ; margin-left: 7%;">
             <div class="container">
                 <h2>Keya Manna</h2>
                 <p class="title">Developer</p>
                 <p>hello eveyone myself Keya Manna, we can assure you that you are in the correct destination.go ahead
                     to use our services</p>
                 <p>keya5@gmail.com.com</p>
                 <p>Contact Number- 8910541973</p>
             </div>
         </div>
     </div>
     </div>

     <div class="column">
         <div class="card">
             <img src="../aboutUs/sanchari.jpg.jpeg" alt="Keya" style="width:30%;height:10% ; margin-left: 7%;">
             <div class="container">
                 <h2>Sanchari Dutta</h2>
                 <p class="title">Designer</p>
                 <p>hello eveyone, we can assure you that you are in the correct destination.go ahead to use our
                     services
                 </p>
                 <p>sanchari@gmail.com.com</p>
                 <p>Contact Number- 9875236698</p>
             </div>
         </div>
     </div>
     </div>

     <div class="column">
         <div class="card">
             <img src="../aboutUs/kunnu.jpg.jpeg" alt="Kuntala" style="width:30%;height:10% ; margin-left: 7%;">
             <div class="container">
                 <h2>Kuntala Roy</h2>
                 <p class="title">Designer</p>
                 <p>hello visitors,thanks to choose our site and we assured that this site will help you to book your
                     preferable restaurant</p>
                 <p>kuntala@gmail.com.com</p>
                 <p>Contact Number- 9586231402</p>
             </div>
         </div>
     </div>
     </div>



     <div class="bg-gray-100 py-10 mb-10 ">
         <div class="container mx-auto text-center">
             <h1 class="text-3xl font-bold text-gray-800 mb-6">Our Preferred Partners</h1>
             <div class="w-full h-2 my-6 bg-gradient-to-r from-yellow-300 to-yellow-600"></div>



             <div class="partnerLogo flex flex-wrap  justify-center items-center mt-5 mb-5 gap-3">
                 <div class="rounded-full overflow-hidden border-4 border-white">
                     <img src="../aboutUs/berbique.jpg" alt="Berbique">
                 </div>
                 <div class="rounded-full overflow-hidden border-4 border-white">
                     <img src="../aboutUs/starbuck.jpg" alt="Starbucks">
                 </div>
                 <div class="rounded-full overflow-hidden border-4 border-white">
                     <img src="../aboutUs/kfc.jpg" alt="KFC">
                 </div>
                 <div class="rounded-full overflow-hidden border-4 border-white">
                     <img src="../aboutUs/mac.jpg" alt="McDonald's">
                 </div>
                 <div class="rounded-full overflow-hidden border-4 border-white">
                     <img src="../aboutUs/itclogo.jpg" alt="ITC Logo">
                 </div>
             </div>
         </div>
     </div>






 </body>

 </html>