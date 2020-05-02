<?php require_once 'connections/conn.php';?>
<?php
$pageRows=5;//每页多少条数据
$page = 1;//第几页，刚开始假设是第1页

if(isset($_GET['page'])){
	$page=$_GET['page'];//
}
MySQLi_query($conn,"set names 'utf8'");
$query_Book="select * from booktable";
$all_Book=MySQLi_query($conn,$query_Book);//得到全部图书
$totalRows=Mysqli_num_rows($all_Book);//总行数，即共有多少本书
$totalPages=ceil($totalRows/$pageRows);//总页数
if($totalPages<1)
    $totalPages=1;
//页号的合法性检查
if($page<1) $page=1;//
//echo $page;
if($page>$totalPages) $page=$totalPages;
$startRow=($page - 1)*$pageRows;//起始行
//echo $page,$startRow;
//echo $startRow;
//limit语法：m,n从第m+1条记录开始，取n条记录
$query_limit=sprintf("%s limit %d,%d",$query_Book,$startRow,$pageRows);
$Book=MySQLi_query($conn,$query_limit) or die(mysqli_error($conn));
//$row_Book=mysqli_fetch_assoc($Book);//得到数据行的关联数组，键是字段名，值是数据
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>网上书店</title>
</head>
<body bgcolor="#f4f4f4">
	<table width="100%" border="0" align="center">
		<tr>
			<td width="27%" height="68" rowspan="2">
				<img width="200" height="106" src="images/book_logo.jpg"/>
			</td>
			<td height="68" colspan="4">
				<font face="隶书" size="+4" color="#cccc00">网上书店</font>
			</td>
			<td width="10%" rowspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="center">欢迎光临我们的网站</td>
		</tr>
		<tr>
    			<td width="15%" height="20" align="left" valign="middle">
				<a href="index.php">首页</a>
			</td>
			<td width="15%" height="20" align="left" valign="middle">
				<a href="allbooklist.php">所有图书</a>
			</td>
			<td width="20%" height="20"><a href="allbooklist_pg.php">所有图书(分页)</a></td>
			<td width="15%" height="20" align="left" valign="middle">
				<a href="insertbook.php">插入书籍</a>
			</td>
			<td width="20%" height="20" align="left" valign="middle">
				<a href="deletebook.php">编辑删除图书</a>
			</td>
			<td width="15%" height="20">&nbsp;</td>
		</tr>
		<tr>
			<td height="169" colspan="6" align="center">
			<table width="100%" border="0">
				<tr>
					<td colspan="4" align="center">书店所有图书</td>
				</tr>
				<tr valign="middle">
					<td align="center">书名</td>
					<td align="center">作者</td>
					<td align="center">图书类型</td>
					<td align="center">图书价格</td>
				</tr>
				<?php while($row_Book=mysqli_fetch_assoc($Book)){ ?>
				<tr valign="middle" align="center">
					<td><?php echo $row_Book['bookname'];?></td>
					<td><?php echo $row_Book['bookauthor'];?></td>
					<td><?php echo $row_Book['booktype'];?></td>
					<td><?php echo $row_Book['bookprice'];?></td>
				</tr>
				<?php }//得到数据行的关联数组 
				?>
			</table>
		</td>
		</tr>
		<tr><td></td><td>
<?php
    if($page==1) echo "首页";
    else{
      echo "<a href='allbooklist_pg.php?page=1'>首页</a>";
    }    
?>
</td><td>
<?php
    if($page==1) echo "上一页";
    else{
      $newpage=$page-1;
      echo "<a href='allbooklist_pg.php?page={$newpage}'>上一页</a>";
    }    
?>
</td><td>
<?php
    if($page==$totalPages) echo "下一页";
    else{
      $newpage=$page+1;
      echo "<a href='allbooklist_pg.php?page={$newpage}'>下一页</a>";
    }    
?>
</td><td>
<?php
    if($page==$totalPages) echo "尾页";
    else{
      echo "<a href='allbooklist_pg.php?page={$totalPages}'>尾页</a>";
    }    
?>
	</td></tr>
		<tr>
			<td colspan="6"><table width="100%" border="0">
				<hr>
				<tr>
					<td align="center" valign="middle">Copyright@2006 lanmo </td>
				</tr>
				<tr>
					<td align="center" valign="middle">XXX Email:lanmo@myweb.com</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</body>
</html>
<?php
	mysqli_free_result($Book);//释放数据
?>