<?php
    session_start(); 
?> 
<!doctype html>
<html lang="ru">
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/steps.css">
    <script src="js/jquery-1.7.2.min.js"></script>
   
    <title>ВКР</title>
  </head>
  <body>
        <?php
        include 'header.php';
        ?>

     <div id="slider-wrap">
          <div id="slider">
            <div class="slide" style="background: url(img/1.jpg) no-repeat center; background-size: cover;">
              <div class="z1text">Туры по России</div>
              <p class="description">Тур по России - это как собирать мозаику из современных мегаполисов и самобытных деревушек, пестроты южных курортов и сдержанной красоты северных пейзажей, культуры не похожих друг на друга народов, живущих в одной стране.</p>
                <button class="calc-trip">Рассчитать тур</button> 
              </div>
            <div class="slide" style="background: url(img/2.jpg) no-repeat center; background-size: cover;">
              <div class="z1text">Туры по Прибалтике</div> 
              <p class="description">Туры в Прибалтику – это и размеренный отдых на пляжах Балтийского моря, и средневековая аура уютных городков, и отличный европейский сервис!</p>
                <button class="calc-trip">Рассчитать тур</button> 
            </div>
            <div class="slide" style="background: url(img/3.jpg) no-repeat center; background-size: cover;">
              <div class="z1text">Туры по центральной Европе</div> 
              <p class="description">Комбинированные туры по Европе - прекрасная возможность посетить несколько стран Европы за одну поездку! Маршруты составляются с учетом удобного проезда, красивых природных ландшафтов по пути следования и наличием уникальных особенностей той или иной страны</p>
                <button class="calc-trip">Рассчитать тур</button> 
            </div>
            <div class="slide" style="background: url(img/4.jpg) no-repeat center; background-size: cover;">
              <div class="z1text">Туры по Скандинавии</div>
              <p class="description">Туры по Скандинавии – прекрасная возможность увидеть схожесть и различия нескольких северных стран. Скандинавия хороша в любое время года, у скандинавов даже есть на этот счет поговорка: «не бывает плохой погоды, бывает только не подходящая одежда».</p>
                <button class="calc-trip">Рассчитать тур</button> 
            </div>
          </div>
      </div>
        
    <article>
      <p id="text-introduction">Успешное путешествие на машине останется с вами на всю жизнь. 
        Машина позволит посмотреть не только большие туристические города, но и маленькие уютные деревеньки, приобщиться к неизведанным местам и природным достопримечательностям. 
        Автомобиль дает свободу передвижений и существенно экономит бюджет, если вас больше 2-х человек. 
        Проезд на общественном транспорте в развитых странах стоит не дешево, и перемещаться на нем получается значительно медленнее. </p>
      <h3>Наши основные направления: </h3>
      <ul class="country">
        <li><img class="flags" src="img/5.jpg"><span>Прибалтика</span></li>
        <li><img class="flags" src="img/6.png"><span>Скандинавия</span></li>
        <li><img class="flags" src="img/7.png"><span>Россия</span></li>
        <li><img class="flags" src="img/8.png"><span>Центральная Европа</span></li>
      </ul>
    </article>

    <article>
        <p id="text-introduction">Уверенно мы можем сказать о том, что тщательно организованное путешествие обходится намного дешевле спонтанного и непродуманного!
           А итоговая цифра потраченных за отпуск денег, как правило, не превышает стоимости семейного тура на какой-либо популярный «недорогой» курорт. 
           При этом море впечатлений, привезенных из автопутешествия, поистине бесценно. 
           Как и пьянящее ощущение свободы, которое дарит самостоятельное путешествие, совершенное не по чужому расписанию, а согласно собственным вкусам и желаниям. </p>
    </article>

    <article>
        <div class="image-tape">
            <img src="img/13.jpg">
            <img src="img/14.jpg">
            <img src="img/15.jpg">
            <img src="img/16.jpg">
            <img src="img/17.jpg">
        </div>
    </article>
  
    
 
  <?php
    include 'footer.php';
   ?>
    

     </body>
     <script type="text/javascript" src="js/slide.js"></script>
</html>