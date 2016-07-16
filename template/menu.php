<div id="header">
      	<ul class="nav nav-tabs ">
            <li><a href="index.php">Main</a></li>
            <li role="presentation" class="dropdown">
    					<a data-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color:inherit;">
             	             <?php 
							if(isset($_SESSION["username"])){
									echo $_SESSION["username"];
							}else{
								echo"Member";
							}
							?>
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                        	<?php 
						if(isset($_SESSION["username"])){?>
								<li><a href="myCode.php">MyCode</a></li>
                            	<li><a href="addCode.php">AddCode</a></li> 
                                <li><a href="logout.php">Logout</a></li>    						
							<?php }else{?>
								<li><a href="login.php">Login</a></li>
                            	<li><a href="register.php">Register</a></li>   						
							<?php }?>	    	                         
                        </ul>
  					</li>
                     <li role="presentation" class="dropdown">
    					<a data-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color:inherit;">
             	        Browse<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                        	<li><a href="list.php?keyword=">Search</a></li>  
                        	<li><a href="list.php?tag=cpp">C++</a></li>    
                            <li><a href="list.php?tag=cs">C#</a></li>    
                            <li><a href="list.php?tag=c">C</a></li>    
                            <li><a href="list.php?tag=java">Java</a></li>    
                            <li><a href="list.php?tag=html">HTML</a></li>    
                            <li><a href="list.php?tag=php">PHP</a></li>                         
                        </ul>
  					</li>
        </ul>          
    </div>