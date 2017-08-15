# GIS

## Install `gdal` which contains `ogr2ogr`:

```console
$ brew tap osgeo/osgeo4mac
$ brew install gdal2 --with-mysql
```

## Get schema

This command shows all schema information about all map files in current directory (`.`):

```console
$ ogrinfo -al -so .
```

## Query map file

This command queries the map files in current directory (`.`), in this case ZIP code data, for the first row where the
ZIP code is between the integer values 07000 and 09000 - the range for New Jersey ZIP codes:

Source: https://www.census.gov/geo/maps-data/data/cbf/cbf_zcta.html

```console
$ ogrinfo \
    -sql 'select * from cb_2016_us_zcta510_500k where cast(ZCTA5CE10 as integer) > 07000 and cast(ZCTA5CE10 as integer) < 09000 limit 1' \
    .
```

## Import rows to MySQL (replace `$DATABASE`, `$TABLE`, `$FILE`):

```console
$ ogr2ogr \
    -f "MySQL" MYSQL:"$DATABASE,host=localhost,user=root,password=root,port=3306" \
    -nln $TABLE \
    -t_srs EPSG:4326 \
    -overwrite $FILE
```
