<?php
error_reporting(0);

if (!isset($_SESSION['LoggedInUser']))
	{
	session_start();
	}

?>

<!DOCTYPE html>

<html>

    <head>
        
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Client Address Book</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    </head>
    
    <body style="padding-top: 60px;">            
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">

        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="clients.php">CLIENT<strong>MANAGER</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
            
            <?php

if ($_SESSION['LoggedInUser'])
	{ ?>

                <ul class="nav navbar-nav">
                    <li><a href="clients.php">My Clients</a></li>
                    <li><a href="add.php">Add Client</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <p class="navbar-text">Hello, <?php
	echo $_SESSION['LoggedInUser']; ?></p>

                    <li><a href="logout.php">Log out</a></li>
                </ul>
                    <?php
	}
  else
	{ ?>
                        <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Login</a></li>
                        </ul>          
                    <?php
	} ?>
          </div>

        </div>

    </nav>
        
    <div class="container">