<div class="search-bar">
    <form class="d-flex" id="searchForm" action="items.php" method="GET">
        <div class="dropdown">
            <!-- dropdown box code -->
            <select class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" name="selectedCategory">
                <!-- default 'categories' label -->
                <option value="">Categories</option>
                <option value=""> All</option>
                <optgroup label="Levels">
                    <!-- php code to take levels from table and display as dropdown options -->
                    <?php
                    session_start(); 
                    include_once ("connection.php");
                    $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 0 ORDER BY category ASC');
                    $stmt->execute();
                    $results = $stmt->fetchAll();

                    foreach ($results as $row): ?>
                        <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                    <?php endforeach ?>
                </optgroup>

                <optgroup label="Subjects">
                    <!-- php code to take levels from table and display as dropdown options -->
                    <?php
                    include_once ("connection.php");
                    $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 1 ORDER BY category ASC');
                    $stmt->execute();
                    $results = $stmt->fetchAll();

                    foreach ($results as $row): ?>
                        <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                    <?php endforeach ?>
                </optgroup>
            </select>
        </div>
        <input class="form-control me-2" type="search" placeholder="Search" name="searchQuery">
        <button class="btn btn-outline-success go-button" type="submit">Go</button>
    </form>
</div>