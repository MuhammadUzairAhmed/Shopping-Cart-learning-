<?php
session_start();
$connect = mysqli_connect("localhost","root","","demo");
if(isset($_POST["add_cart"]))
{
if(isset($_SESSION["shopping_cart"]))
{
$item_array_id = array_column($_SESSION["shopping_cart"],"item_id");
if(!in_array($_GET["id"], $item_array_id))
{
$count = count($_SESSION["shopping_cart"]);
$item_array =array (
'item_id' => $_GET["id"],
'item_name' => $_POST["hidden_name"],
'item_price' => $_POST["hidden_price"],
'item_quantity' => $_POST["quantity"]
);
$_SESSION["shopping_cart"][$count] = $item_array ;
}
else
{
echo '<script>alert("Item already added")</script>';
echo '<script>window.location="index1.php"</script>';
}

}
else
{

$item_array =array (
'item_id' => $_GET["id"],
'item_name' => $_POST["hidden_name"],
'item_price' => $_POST["hidden_price"],
'item_quantity' => $_POST["quantity"]
);
$_SESSION["shopping_cart"][0] = $item_array ;
}
}
if(isset($_GET["action"]))
{
if($_GET["action"] == "delete")
{
foreach ($_SESSION["shopping_cart"] as $keys => $values)
{
if($values["item_id"] == $_GET["id"])
{
unset($_SESSION["shopping_cart"][$keys]);
echo '<script>alert("item removed")</script>';
echo '<script>window.location = "index1.php"</script>';
}
}
}
}
?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <scr ipt src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<h3 align="center">Grocery Shopping</h3><br />
<?php
$result = mysqli_query($connect, 'select * from product');

if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_array($result))
{
?>
<div class="col-md-4">
<form method="post" action="index1.php?action=add&id=<?php echo $row['id'];?>">
<div class="container">
<h4 class="tex-info"><?php echo $row["name"];?></h4>
<h4 class="tex-info"><?php echo $row["price"];?></h4>
<input type="text" name="quantity" class="form-control" value="1">
<input type="hidden" name="hidden_name" value="<?php echo $row["name"];?>">
<input type="hidden" name="hidden_price" value="<?php echo $row["price"];?>">
<input type="submit" name="add_cart" value="add to cart">
</div>
</form> 
</div>
<?php 
}
}
?>

<div style="clear:both"></div>
<br />
<h3>order details</h3>
<div class="table table-responsive">
<table class="table table-bordered">
<tr>
<th>item naem</th>
<th>quantity</th>
<th>price</th>
<th>total</th>
<th>action</th>
</tr>
<?php
if(!empty($_SESSION["shopping_cart"]))
{
$total = 0;
foreach($_SESSION["shopping_cart"] as $keys => $values)
{
?>
<tr>

<td><?php echo $v1=$values[ "item_name"];?></td>
<td><?php echo $v2=$values[ "item_quantity"];?></td>
<td><?php echo $v3=$values[ "item_price"];?></td>
<td><?php echo $v4=number_format($values[ "item_quantity"] * $values[ "item_price"],2);?></td>
<td><a href="index1.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="danger"></span>Remove</a></td>
</tr>
<?php
$total = $total + ($values[ "item_quantity"] * $values[ "item_price"]); 
}
?>
<tr>
<td colspan="3" align="right">Total price</td>
<td align="right"><?php echo number_format($total,2) ?></td>
</tr>
<?php


}
?>
</table>
</div>
</div>
<br /> 
<input type="button" value="Home" class="homebutton" id="btnHome" onClick="Javascript:window.location.href = 'sc.php';" />
</body>
</html>