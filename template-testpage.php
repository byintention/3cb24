<?php
/**
 * Template Name: Style test page
 * Shows examples of many included styles
 *
 * @package 3cb
 */

get_header(); ?>
<div class="filler"></div>
<div class="filler"></div>
<div class="container grid">
	<div id="content" class="twelve columns clearfix" style="padding:50px 0;">
	
		<h1>Grid &amp; Style Test</h1>
		
		<?php
		// Display the page content/body.
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?>
		
		<h2>Heading 2</h2>
		
		<h3>Heading 3</h3>
		
		<h4>Heading 4</h4>
		
		<h5>Heading 5</h5>
		
		<h6>Heading 6</h6>
		
		<p class="has-large-font-size">
			Larger text: class <code>has-large-font-size</code> Nullam luctus sagittis urna. Vivamus nibh. Fusce
			ut nunc. Vivamus sed felis. Nam elit diam, auctor eu, eleifend vel, dictum quis, leo. Pellentesque fringilla, tellus quis auctor nonummy, lorem varius massa, at vestibulum enim nibh ac massa.
		</p> 
		
		<p>Paragraph text - Lorem ipsum dolor sit amet,	consectetuer adipiscing elit. Suspendisse lectus nisl, semper sit amet, blandit at, lacinia et, sem. <a href="#">Sed pellentesque turpis ut risus</a>. Nullam luctus sagittis urna. Vivamus nibh. Fusce ut nunc. Vivamus sed felis. Nam elit diam, auctor eu, eleifend vel, dictum quis, leo.  Pellentesque fringilla, tellus quis auctor nonummy, lorem varius massa, at vestibulum  enim nibh ac massa.</p>
		 
		<p class="has-small-font-size">
			Smaller text:  class <code>has-small-font-size</code> Nullam luctus sagittis urna. Vivamus nibh. Fusce
			ut nunc. Vivamus sed felis. Nam elit diam, auctor eu, eleifend vel, dictum quis, leo. Pellentesque fringilla, tellus quis auctor nonummy, lorem varius massa, at vestibulum enim nibh ac massa.
		</p>
		
		<p>Abbreviation: <abbr lang="en" title="World Wide Web Consortium">W3C</abbr></p>
		
		<p><strong>Strong text here</strong></p>
		
		<p><em>Emphasis on this bit of copy</em></p>
		
		<br>
		
		<h3>Buttons &amp; Fields</h3>
		
		<p class="clearfix">
			<a class="btn btn-primary" href="#">Anchor</a>
			<button class="btn">Button</button>
			<input class="btn" type="submit" value="Input" />
			<input class="" type="text" value="Input" style="display:inline-block;width:200px" />
		</p>
		
		<br>
		
		<h3>Utility Classes</h3>
		
		<p class="white rounded padded shadow">This paragraph has classes <code>white rounded padded shadow</code> Sed pellentesque turpis ut risus. Nullam luctus sagittis urna. Vivamus nibh. Fusce ut nunc. Vivamus sed felis. Nam elit diam, auctor eu, eleifend vel, dictum quis, leo. Pellentesque fringilla, tellus quis auctor nonummy, pede lorem varius massa, at vestibulum enim nibh ac massa.
		</p>
		
		<p class="centre">Centred</p>
		
		<br>
		
		<p class="left" style="background:#eee;padding:10px;">Left</p>
		
		<p class="right" style="background:#eee;padding:10px;">Right</p>
		
		<p class="clearance">Donec velit. Suspendisse rutrum nunc sed tellus. Maecenas interdum placerat nulla. Etiam sit amet orci at lectus posuere nonummy. Praesent rutrum ante eget nisl. Nulla bibendum sodales quam. Phasellus ipsum.
		</p>

		<br>
		
		<h3>Notifications</h3>
		
		<p class="positive">Positive message</p>
		
		<p class="warning">Warning message</p>
		
		<p class="negative">Negative message</p>
		
		<br>
		
		<h3>Lists</h3>
		
		<ul>
			<li>Ipsum Modi Dolores Mollitia Est Pariatur Deleniti Aliquid Quo Culpa Ut Sit</li>
			<li>Velit Quos Voluptatem Quo Qui Adipisci Libero Quia Veritatis Et Eos Laudantium Dolorem Perferendis Ea Facilis Omnis Corrupti Ipsum Ut Suscipit Dolor Velit Suscipit Aut Sint Veniam Vero Temporibus Magni Atque Quaerat Repellendus Fuga Repellendus Voluptas Voluptatem Numquam </li>
			<li>List item 3</li>
		</ul>
		
		<ol>
			<li>Velit Quos Voluptatem</li>
			<li>Quo Qui Adipisci Libero Quia Veritatis Et Eos Laudantium Dolorem Perferendis Ea Facilis Omnis Corrupti Ipsum Ut Suscipit Dolor Velit Suscipit Aut Sint Veniam Vero Temporibus Magni Atque Quaerat Repellendus Fuga Repellendus Voluptas Voluptatem Numquam Ipsum Modi Dolores Mollitia Est Pariatur Deleniti Aliquid Quo Culpa Ut Sit</li>
			<li>List item 3</li>
		</ol>
		
		<br>
		
		<h3>Blockquote</h3>
		
		<blockquote><p>Etiam sit amet orci at lectus posuere nonummy. Praesent rutrum ante eget nisl. Nulla bibendum sodales quam. <code>Preformatted Code</code> Phasellus ipsum.</p></blockquote>
		
		<br>
		
		<h3>Pre Tag</h3>
		
		<pre><code>Preformatted Code
	and again
		another line</code></pre>
		
		<hr>
		
		<h3>Forms</h3>
		
		<div class="wpcf7">
			<form id="enquiry" action="" method="post" name="enquiry" class="wpcf7-form">
			<fieldset>
				<legend>Fieldset</legend>
				<div>
					<label for="name">Name:
					<input id="name" type="text" name="name" />
					</label>
				</div>
				<div>
					<label for="company">Company:
					<input id="company" type="text" name="company" />
					</label>
				</div>
				<div>
					<label for="email">Email:
					<input id="email" type="text" name="email" />
					</label>
				</div>
				<div>
					<label for="state">State:
					<select id="state" name="state">
						<option value="CA">California -- CA</option>
						<option value="CO">Colorado -- CO</option>
						<option value="CN">Connecticut -- CN</option>
					</select>
					</label>
				</div>
				<div>
					<label for="phone">Phone:
					<input id="phone" type="text" name="phone" />
					</label>
				</div>
				<div>
					<label>
						Your Enquiry:
						<textarea id="body" cols="10" name="body" rows="4"></textarea>
					</label>
				</div>
				
				<div>
					<label>
						<input type="checkbox" name="acceptance-828" value="1" aria-invalid="false">
						I agree with the thing
					</label>
				</div>
				
				<div>
					<input id="send" type="submit" name="send" value="Send" />
				</div>
			</fieldset>	
		</form>
		</div>
		
		<br>
		
		<br>
		
		<h3>Tables</h3>
		
		<table cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Title</th>
					<th>Title</th>
					<th>Title</th>
					<th>Title</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Data</td>
					<td>Data</td>
					<td>Data</td>
					<td>Data</td>
				</tr>
				<tr>
					<td>Data</td>
					<td>Data</td>
					<td>Data</td>
					<td>Data</td>
				</tr>
				<tr>
					<td>Data</td>
					<td>Data</td>
					<td>Data</td>
					<td>Data</td>
				</tr>
			</tbody>
		</table>
		
		<p>Donec velit. Suspendisse rutrum nunc sed tellus. Maecenas interdum placerat nulla. 
			Etiam sit amet orci at lectus posuere nonummy. Praesent rutrum ante eget nisl. 
			Nulla bibendum sodales quam. Phasellus ipsum.</p>
		
	</div> <!-- end 12 columm text tests -->
	
</div> <!-- end container -->
	
		<div class="container">
			<div class="twelve columns">
				<h3>Grid System</h3>
			</div>	
		</div>
	
		<div class="container gridRow">
		
			<div class="one column">1
			</div>
		
			<div class="one column">2
			</div>
			
			<div class="one column">3
			</div>
			
			<div class="one column">4
			</div>
			
			<div class="one column">5
			</div>
			
			<div class="one column">6
			</div>
			
			<div class="one column">7
			</div>
			
			<div class="one column">8
			</div>
			
			<div class="one column">9
			</div>
			
			<div class="one column">10
			</div>
			
			<div class="one column">11
			</div>
			
			<div class="one column">12
			</div>
		
		</div> <!-- end 12 single columns -->
		
		<div class="container gridRow">
		
			<div class="two columns">Totam quia non minus iusto earum soluta quas et qui odit quo ad ut. Et aspernatur ipsa odio eveniet reiciendis dolorum porro deleniti tenetur odit a quos aut.
			</div>
		
			<div class="two columns">
				Voluptates velit rem molestias autem cum consequatur doloribus hic vel aut qui. In officia amet rerum cum.
			</div>
			
			<div class="two columns">Ullam modi quidem aut reiciendis at sequi excepturi voluptatem dolorum fugit ut. Corporis quos repellendus at pariatur quam nihil quibusdam. Magnam quis qui incidunt ut corrupti eligendi placeat. Voluptates eligendi qui iure iusto ut quia est distinctio repellendus ea et dicta et reiciendis voluptatem. Voluptatibus quia quos reiciendis quam laborum consectetur suscipit consequatur cupiditate quia cumque tempora.
			</div>
			
			<div class="two columns">Est voluptas ea impedit molestiae pariatur voluptas. Consectetur doloremque commodi sunt enim porro saepe consequatur dolorem. Voluptatum atque eius deleniti illum voluptate voluptatem aspernatur eum doloribus saepe et. Unde sapiente tempora at.
			</div>
			
			<div class="two columns">Ratione quos illo sed vel. Ipsa inventore aperiam quis repellendus molestias in ut explicabo ut enim eveniet nostrum dolorum dolorum. Voluptas omnis est dolorum enim laboriosam quis neque vel. Magni possimus animi itaque nemo nisi quia porro ullam occaecati atque consectetur autem. Non unde et beatae quis officia quia quam est non dolore alias illo doloribus. Excepturi sint necessitatibus molestiae totam quae eos.
								
			</div>
			
			<div class="two columns">6
			</div>
		
		</div> <!-- end 6 double columns -->
		
		<div class="container gridRow">
		
			<div class="one-quarter column">One Quarter
			</div>
		
			<div class="one-quarter column">One Quarter
			</div>
			
			<div class="one-quarter column">One Quarter
			</div>
			
			<div class="one-quarter column">One Quarter
			</div>
		
		</div> <!-- end 4 quarter columns -->
		
		<div class="container gridRow">
		
			<div class="one-quarter column">One Quarter
			</div>
		
			<div class="three-quarter column">Three Quarters
			</div>
		
		</div> <!-- end 1/3 quarter columns -->
		
		<div class="container gridRow">
		
			<div class="one-half column">One Half
			</div>
		
			<div class="one-half column">One Half
			</div>
		
		</div> <!-- end half columns -->
		
		<div class="container gridRow">
		
			<div class="one-third column">One Third
			</div>
		
			<div class="one-third column">One Third
			</div>
			
			<div class="one-third column">One Third
			</div>
		
		</div> <!-- end 3 third columns -->
		
		<div class="container gridRow">
		
			<div class="one-third column">One Third
			</div>
		
			<div class="two-thirds column">Two Thirds
			</div>
		
		</div> <!-- end 2 third columns -->
		
		<div class="container gridRow">
		
			<div class="five columns">Five
			</div>
			<div class="five columns">Five
			</div>
		
			<div class="two columns">Two 
			</div>
		
		</div> <!-- end 2 third columns -->

		<br><br>

<?php get_footer(); ?>