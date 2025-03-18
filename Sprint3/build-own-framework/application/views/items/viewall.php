<form action="/application/views/items/add.php" method="post">
    <input type="text" value="I have to..." onclick="this.value=''" name="todo">
    <input type="submit" value="add">
</form>
<br/><br/>

<?php 
$number = 0;
// Check if $todo is set and is an array before looping
if (isset($todo) && is_array($todo) && !empty($todo)):
?>
    <?php foreach ($todo as $todoitem): ?>
        <a class="big" href="../items/view/<?php echo $todoitem['Item']['id']; ?>/<?php echo strtolower(str_replace(" ","-",$todoitem['Item']['item_name'])); ?>">
            <span class="item">
                <?php echo ++$number; ?>
                <?php echo $todoitem['Item']['item_name']; ?>
            </span>
        </a><br/>
    <?php endforeach; ?>
<?php else: ?>
    <p>No items in your todo list yet. Add one above!</p>
<?php endif; ?>