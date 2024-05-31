<?php
 $page          = isset($_GET['cfe_page']) ? absint($_GET['cfe_page']) : 1;
 $limit         = 10;
 $offset        = ($page - 1) * $limit;
 $entries       = $wpdb->get_results("SELECT * FROM $this->table_name LIMIT $offset, $limit");
 $total_entries = $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
 $total_pages   = ceil($total_entries / $limit);

?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?php echo esc_html($entry->id); ?></td>
                <td><?php echo esc_html($entry->first_name); ?></td>
                <td><?php echo esc_html($entry->last_name); ?></td>
                <td><?php echo esc_html($entry->email); ?></td>
                <td><?php echo esc_html($entry->phone); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<nav>
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?cfe_page=<?php echo $page - 1; ?>" title="Previous">
                    <span aria-hidden="true">Previous</span>
                </a>
            </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
                <a class="page-link" href="?cfe_page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?cfe_page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">Next</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>