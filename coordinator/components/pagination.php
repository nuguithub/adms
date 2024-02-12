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
            
            $paginationUrl = "?course_code=$courseCode&page=";
            
            if ($current_page > 1) {
                echo '<li class="page-item"><a class="page-link" id="page-first" href="' . $paginationUrl . '1">First</a></li>';
                echo '<li class="page-item"><a class="page-link" id="page-previous" href="' . $paginationUrl . ($current_page - 1) . '">Previous</a></li>';
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
                echo '" id="page-' . $i . '" href="' . $paginationUrl . $i . '">' . $i . '</a></li>';
            }

            if ($endPage < $totalPages) {
                echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
            }

            if ($current_page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" id="page-next" href="' . $paginationUrl . ($current_page + 1) . '" aria-label="Next">Next</a></li>';
                echo '<li class="page-item"><a class="page-link" id="page-last" href="' . $paginationUrl . $totalPages . '" aria-label="Last">Last</a></li>';
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