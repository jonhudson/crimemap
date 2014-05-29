<?php include 'header.php' ?>
<div class="col-xs-3">
    <form id="visualiseform">
        <div class="form-group">
            <label for="location">Enter location:</label>
            <input type="text" name="location" id="location" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="category">Choose crime category:</label>
            <select id="category" name="category" class="form-control">
                <?php foreach($categories as $cat): ?>                    
                    <option value="<?php echo htmlentities(trim($cat['crime_type'])); ?>"><?php echo htmlentities($cat['crime_type']); ?></option>
                <?php endforeach; ?>
            </select>
        </div> 
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>                    
</div>
<div class="col-xs-9 height-100">
    <div id="graph-container" class="height-100">
        <canvas id="line-chart" width="400" height="400"></canvas>
    </div>
</div>
<?php include 'footer.php' ?>
            
