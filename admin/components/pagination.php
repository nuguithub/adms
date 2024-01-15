<style>
.pagination .page-item a {
    color: #666;
}
</style>

<div class="position-relative">
    <div class="mx-auto">
        <?php
        if ($totalPages > 1) {
            echo '<nav aria-label="Page navigation">';
            echo '<ul class="pagination justify-content-center">';

            if ($current_page > 1) {
                echo '<li class="page-item"><a class="page-link" id="page-first" href="?page=1">First</a></li>';
            }

            if ($current_page > 1) {
                echo '<li class="page-item"><a class="page-link" id="page-previous" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
            }

            $startPage = max(1, min($totalPages - 4, $current_page));
            $endPage = min($totalPages, $startPage + 4);
            
            if ($startPage > 1) {
                echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                echo '<li class="page-item"><a class="page-link page-number';
                if ($i === $current_page) {
                    echo ' active-page';
                }
                echo '" id="page-' . $i . '" href="?page=' . $i . '">' . $i . '</a></li>';
            }

            if ($endPage < $totalPages) {
                echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
            }

            if ($current_page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" id="page-next" href="?page=' . ($current_page + 1) . '">Next</a></li>';
            }

            if ($current_page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" id="page-last" href="?page=' . $totalPages . '">Last</a></li>';
            }

            echo '</ul>';
            echo '</nav>';
        }
    ?>
    </div>
</div>



<script>
var currentPage = <?php echo $current_page; ?>;

var activePageElement = document.getElementById('page-' + currentPage);
if (activePageElement) {
    activePageElement.style.backgroundColor = '#037a02';
    activePageElement.style.color = '#fff';
}
</script>