<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>quickSearch jQuery plug-in</title>
		
		<link rel="stylesheet" href="style.css" type="text/css" media="all" title="" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
		<script type="text/javascript" src="http://github.com/riklomas/quicksearch/raw/dev/jquery.quicksearch.js"></script>
		
		<script type="text/javascript">
			$(function () {
				/*
				Example 1
				*/

					if($('input#id_search').quicksearch('div#busca tbody tr')){
						
					}

				
			});
		</script>
	</head>
	<body>
		<h1>jQuery quickSearch</h1>
		
		<p class="github"><a href="http://github.com/riklomas/quicksearch">More information and download at Github</a></p>
		
		<h2 id="examples">Examples</h2>
		<h3>Simple example</h3>
		
				<input type="text" name="search" value="" id="id_search" placeholder="Search" autofocus />
        <div id="busca">
		<table id="table_example">
		<?
		for($i=0;$i<1000;$i++){
		?>			
		
				<tr>

					<td><? echo $i; ?></td>
					<td>http://gmail.com</td>
				</tr>
        
            <?
		}
		?>
    </table>
				
	    </div>
	</body>
</html>