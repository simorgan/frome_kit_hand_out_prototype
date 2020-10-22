# frome_kit_hand_out_prototype
04/10/2020

<h2>The Problem. </h2>
<p>With each playing membership comes with a free player kit bundle, but they have no way of confirming which members have paid and if the bundle has been issue. </p>


<h2>The Project.</h2>
<p>This is a prototype for a web application so that each player collecting the kit can be confirmed if the membership payment has been paid and if the bundle has been issued yet</p>

<h3>The Application </h3>
<ul>
<li>
When the member has paid a required minimum membership amount, their details will be added to the database. </li>
<li>Each added member will be automatically emailed a kit voucher with confirmation that their kit is ready for them to collect and issued with an ID number.  </li>
<li>Up on collection of the kit, the member will need to show the kit voucher displaying their unique ID number</li>
<li>The person issuing the kit will enter the ID and this will display the members name, ID and kit sizes plus if any of the kit have been issued already </li>
<li>When the kit is issued, the app user will select the appropriate selections updating the database. </li>
<li>When the kit has been issued the member and club officials will be automictically emailed from the app to confirm the kit has been issued.</li>
</u>
<h3>Testing </3>
<p> The application has been use in a real world situation and is fulfilling the expectations saving loss of kit to unpaying members.</p>

<h4>What Needs Changing</h4>
<ul>
<li> The Done submits need changing to checkboxes, to avoid submits going to many times if the button is pressed more than once if there is any delay in the response </li>
<li>The user needs to see a full list of added members to check if someone has lost the email containing the kit collect voucher</li>
</ul>

<h4>What Needs Adding</h4>
<li>Page for showing a list of all paid members that can be searched through</li>
<li>Option to change the sizes, due to some kit not fitting and needed to be changed</li>
<li>Add member section so a member can be added automatically through the UI instead directly into the database</li>
<li>Stock levels of kit. There would need to somewhere stock check data can be entered, and this will be updated whenever kit is issued. Plus, this can show what is the most required kit sizes, helping with kit ordering for future seasons </li>
<li>secure logging system, so personal data can be kept securely </li>
</ul>

<h3>What’s Next</h3>
<p>This will be built using Laravel framework, with the use of Fortify to keep it secure. There is a bigger demand for displaying membership data and other data within Frome RFC’s committee, so this will be part of a bigger application with different features.</p>

<a href="https://github.com/simorgan/Frome-RFC-Portal2">Link to the repository of the master build</a>



