<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var mixed $error
 * @var mixed $success
 * @var mixed $onlyChart
 * @var mixed $cachedAt
 * @var mixed $justCached
 * @var mixed $dataSource
 * @var mixed $chartType
 */
?>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error.first(200) ?></div>
<?php elseif (!$success): ?>
    <?php if ($onlyChart): ?>
        <p class="text-muted">Select variables</p>
    <?php else: ?>
        <div class="alert alert-info">Can’t preview queries with variables...yet!</div>
    <?php endif ?>
<?php else: ?>
    <?php if (!$onlyChart): ?>
        <?php if ($cachedAt || $justCached): ?>
            <p class="text-muted" style="float: right;">
                <?php if ($cachedAt): ?>
                    Cached <?= $this->Time->timeAgoInWords($cachedAt, ['includeSeconds' => true]) ?> ago
                <?php elseif (!params[$dataSource]): ?>
                    Cached just now
                    <?php if ($dataSource.cache_mode === 'slow'): ?>
                        (over <?= "%g" % $dataSource.cache_slow_threshold ?>s)
                    <?php endif ?>
                <?php endif ?>

                <?php if ($query && !params[:dataSource]): ?>
    <?= $this->Form->postLink('Refresh', [$this->request->getQuery()]) ?>
    <?php endif ?>
            </p>
        <?php endif ?>
        <p class="text-muted">
        <?= __n('rows', 'row', count($rows)) ?>

        <?php $checks.select(&:state).each do |check| ?>
        &middot; <small class="check-state <?= check.state.parameterize.gsub("-", "_") ?>"><?= link_to check.state.upcase, edit_check_path(check) ?></small></small>
        <?php if (check.try(:message)): ?>
        &middot; <?= check.message ?>
        <?php endif ?>
<?php endif ?>
    </p>
<?php endif ?>
    <?php if (count($rows) > 0): ?>
<?php values = $rows.first ?>
    <?php chart_id = SecureRandom.hex ?>
    <?php column_types = $result.column_types ?>
    <?php chartType = $result.chartType ?>
    <?php chart_options = {id: chart_id, min: nil} ?>
<?php series_library = {} ?>
<?php target_index = $columns.index { |k| k.downcase == "target" } ?>
<?php if (target_index): ?>
    <?php series_library[target_index - 1] = {pointStyle: "line", hitRadius: 5, borderColor: "#109618", pointBackgroundColor: "#109618", backgroundColor: "#109618"} ?>
<?php endif ?>
<?php if (blazer_maps? && count($markers) > 0): ?>
<div id="map" style="height: <?= $onlyChart ? 300 : 500 ?>px;"></div>
<script>
    L.mapbox.accessToken = '<?= ENV["MAPBOX_ACCESS_TOKEN"] ?>';
    var map = L.mapbox.map('map', 'ankane.ioo8nki0');
    <?= blazer_js_var "markers", $markers ?>
    var featureLayer = L.mapbox.featureLayer().addTo(map);
    var geojson = [];
    for (var i = 0; i < markers.length; i++) {
        var marker = markers[i];
        geojson.push({
            type: 'Feature',
            geometry: {
                type: 'Point',
                coordinates: [
                    marker.longitude,
                    marker.latitude
                ]
            },
            properties: {
                description: marker.title,
                'marker-color': '#f86767',
                'marker-size': 'medium'
            }
        });
    }
    featureLayer.setGeoJSON(geojson);
    map.fitBounds(featureLayer.getBounds());
</script>
<?php elseif ($chartType === 'line'): ?>
<?= $this->Chart->lineChart $columns[1..-1].each_with_index.map{ |k, i| {name: blazer_series_name(k), data: $rows.map{ |r| [r[0], r[i + 1]] }, library: series_library[i]} }, chart_options ?>
<?php elseif (chartType == "line2"): ?>
<?php
/** @var \Cake\Collection\Collection $row */
?>
<?= $this->Chart->lineChart $rows.group_by { |r| v = r[1]; ($boom[$columns[1]] || {})[v.to_s] || v }.each_with_index.map { |(name, v), i| {name: blazer_series_name(name), data: v.map { |v2| [v2[0], v2[2]] }, library: series_library[i]} }, chart_options ?>
<?php elseif (chartType == "bar"): ?>
<?= column_chart (values.size - 1).times.map { |i| name = $columns[i + 1]; {name: blazer_series_name(name), data: $rows.first(20).map { |r| [($boom[$columns[0]] || {})[r[0].to_s] || r[0], r[i + 1]] } } }, id: chart_id ?>
<?php elseif (chartType == "bar2"): ?>
<?php first_20 = $rows.group_by { |r| r[0] }.values.first(20).flatten(1) ?>
<?php labels = first_20.map { |r| r[0] }.uniq ?>
<?php series = first_20.map { |r| r[1] }.uniq ?>
<?php labels.each do |l| ?>
<?php series.each do |s| ?>
<?php first_20 << [l, s, 0] unless first_20.find { |r| r[0] == l && r[1] == s } ?>
<?php endif ?>
<?php endif ?>
<?= column_chart first_20.group_by { |r| v = r[1]; ($boom[$columns[1]] || {})[v.to_s] || v }.each_with_index.map { |(name, v), i| {name: blazer_series_name(name), data: v.sort_by { |r2| labels.index(r2[0]) }.map { |v2| v3 = v2[0]; [($boom[$columns[0]] || {})[v3.to_s] || v3, v2[2]] }} }, id: chart_id ?>
<?php elseif (chartType == "scatter"): ?>
<?= scatter_chart $rows, xtitle: $columns[0], ytitle: $columns[1], id: chart_id ?>
<?php elseif ($onlyChart): ?>
<?php if ($rows.size == 1 && $rows.first.size == 1 ?>
    <?php v = $rows.first.first ?>
<?php if (v.is_a?(String) && v == "" ?>
    <div class="text-muted">empty string</div>
<?php else ?>
<p style="font-size: 160px;"><?= blazer_format_value($columns.first, v) ?></p>
<?php endif ?>
<?php else ?>
<?php $no_chart = true ?>
<?php endif ?>
<?php endif ?>

<?php unless $onlyChart && !$no_chart ?>
<?php header_width = 100 / $columns.size.to_f ?>
<div class="results-container">
    <?php if ($columns == ["QUERY PLAN"] ?>
    <pre><code><?= $rows.map { |r| r[0] }.join("\n") ?></code></pre>
    <?php else ?>
    <table class="table results-table" style="margin-bottom: 0;">
        <thead>
        <tr>
            <?php $columns.each_with_index do |key, i| ?>
            <?php type = $column_types[i] ?>
            <th style="width: <?= header_width ?>%;" data-sort="<?= type ?>">
                <div style="min-width: <?= $min_width_types.include?(i) ? 180 : 60 ?>px;">
                    <?= key ?>
                </div>
            </th>
            <?php endif ?>
        </tr>
        </thead>
        <tbody>
        <?php $rows.each do |row| ?>
        <tr>
            <?php row.each_with_index do |v, i| ?>
            <?php k = $columns[i] ?>
            <td>
                <?php if (v.is_a?(Time) ?>
                <?php v = blazer_time_value($dataSource, k, v) ?>
                <?php endif ?>

                <?php unless v.nil? ?>
                <?php if (v.is_a?(String) && v == "" ?>
                    <div class="text-muted">empty string</div>
                <?php elseif ($linked_columns[k]): ?>
                <?= link_to blazer_format_value(k, v), $linked_columns[k].gsub("{value}", u(v.to_s)), target: "_blank" ?>
                <?php else ?>
                <?= blazer_format_value(k, v) ?>
                <?php endif ?>
                <?php endif ?>

                <?php if (v2 = ($boom[k] || {})[v.nil? ? v : v.to_s] ?>
                <div class="text-muted"><?= v2 ?></div>
                <?php endif ?>
            </td>
            <?php endif ?>
        </tr>
        <?php endif ?>
        </tbody>
    </table>
    <?php endif ?>
</div>
<?php endif ?>
<?php elseif ($onlyChart): ?>
    <p class="text-muted">No rows</p>
<?php endif ?>
<?php endif ?>
