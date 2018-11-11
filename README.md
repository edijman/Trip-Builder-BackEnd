# Trip-Builder-BackEnd
<p>This is Trip Builder Restful API built with <a href="https://www.slimframework.com/" target="_blank">Slim Framework</a>. There are two main routes
in in the application:
<ul>
<li>
    <b>http://*Your Domain URL*/cities</b>
    <br>
    This returns the list of cities in the database
 </li>
<li>
  <b>http://*Your Domain URL*/itinerary/{departure_city_id}/{arrival_city_id}/{departureDate}'</b>
  <span>This returns the itinerary based on the departure city id, arrival city id and the departure date. This route is used for both One Way Trip and Round Trip</span>  
</li>
</ul></p>
<h2>Installation</h2>
<ol>
  <li>Install Composer, follow the instruction <a href="https://getcomposer.org/" target="_blank">here</a>.</li>
  <li>Download the Trip Builder Backend program, go to your terminal, navigate to the director with the terminal, and run 'composer install' to install the dependencies</li>
  <li>Place the updated program in directory of the server being used</li>
  <li>Create the database that would be used, give it a name of your choice, then go to src/config/db.php and update the config file.</li>
  <li>Copy the content in _questions.sql and run in the datebase you just created, to create the tables and content</li>
  <li>Start the server you are using and go to 'http://*server name*/*name of directory file is placed*/*File name*/cities' This should successful return a json object of cities.</li>
</ol>
