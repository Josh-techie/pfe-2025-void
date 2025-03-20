<?php if (!empty($todo)) : ?>
    <h2><?php echo htmlspecialchars($todo['item_name']); ?></h2>
    <a class="big" href="/index.php?url=items/delete/<?php echo htmlspecialchars($todo['id']); ?>">
        <span class="item">Delete this item</span>
    </a>
<?php else : ?>
    <p>No item found.</p>
<?php endif; ?>
