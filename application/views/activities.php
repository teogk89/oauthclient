<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php foreach($activities as $n): ?>
<table>

<tr>
<td>Type</td>
<td><?php echo $n['type'] ?></td>
</tr>
<tr>
<td>Duration</td>
<td><?php echo $n['duration'] ?></td>
</tr>
<tr>
<td>Total Distance</td>
<td><?php echo $n['total_distance'] ?></td>
</tr>
<tr>
<td>Start time</td>
<td><?php echo $n['start_time'] ?></td>
</tr>
<tr>
<td>More details</td>
<td><a href="<?php echo $n['link']; ?>">Link</a></td>
</tr>
</table>
<br/>
<?php endforeach ?>
</body>
</html>