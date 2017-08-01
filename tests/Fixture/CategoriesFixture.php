<?php
declare(strict_types = 1);

namespace OurSociety\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CategoriesFixture extends TestFixture
{
    public const ID_AGRICULTURE_FOOD = 'de7040fd-87c4-33ad-9f61-b9e835c91bb8';
    public const ID_ANIMALS = '213e2c94-6f7c-3d58-9f2e-134b9ee3dddd';
    public const ID_ARMED_FORCES_NATIONAL_SECURITY = '794e428c-53ca-35df-a09e-111f32ecd7b4';
    public const ID_ARTS_CULTURE_RELIGION = 'ff430a43-9376-3ec2-876f-53922c672118';
    public const ID_CIVIL_RIGHTS = 'b6141312-a703-3c45-aaa7-c9ce3fc6b676';
    public const ID_COMMERCE = '23ab4609-26e8-3227-a8a9-41a3e0c66931';
    public const ID_CRIME_LAW_ENFORCEMENT = 'db2c8d74-106f-3734-bff1-674d5e045f1b';
    public const ID_DOMESTIC_SURVEILLANCE = '10c581cd-9ffe-3f5c-a348-dd9fe0ec969d';
    public const ID_ECONOMICS_FINANCE = '93c691d9-2744-3116-943b-19a65b22f073';
    public const ID_EDUCATION = '4531be47-7c58-32d2-895e-fa18ee7bc16b';
    public const ID_EMERGENCY_MANAGEMENT = '3fa61c10-b6d8-34ed-88db-d523cef14809';
    public const ID_ENERGY = '2b3836d2-2d2e-35af-a27a-8d2fbff862c0';
    public const ID_ENVIRONMENT = '2ae85612-08b9-3f89-b56f-506166dd4ae4';
    public const ID_FIREARMS = '6c9ae772-6f7e-3a98-8e7b-06f7268dbf85';
    public const ID_FOREIGN_POLICY = 'ec10f443-d394-3128-98ec-af83d4532046';
    public const ID_GOVERNMENT_OPERATION_POLITICS = '77371e03-159e-3146-9ffd-2ec34fa44eaa';
    public const ID_HEALTHCARE = '1d01b84a-12b1-3e5a-b2b1-ec50d28ad03f';
    public const ID_HOUSING_COMMUNITY = 'ac79cb54-c030-38f8-acdb-f1c59e6edfc8';
    public const ID_IMMIGRATION = 'e558921b-1019-3724-904c-084f25b44b4d';
    public const ID_LABOR_EMPLOYMENT = '446240f1-7928-39c2-a64e-c20c7427fcdb';
    public const ID_LAW = '8bf2b519-a6ce-3eda-85ca-699769b69e44';
    public const ID_NATIVE_AMERICANS = 'f92c5482-6f45-382c-8f52-5e9d066488db';
    public const ID_NATURAL_RESOURCES = '8dc5a016-5476-3738-afda-6805ae835ec3';
    public const ID_NEWS_INFORMATION = 'a6439f06-d24f-32a0-b862-627fb321252b';
    public const ID_SCIENCE_TECHNOLOGY = '9f94a011-a10a-3fe5-a742-2153fab72b90';
    public const ID_SOCIAL_WELFARE = 'e05a929c-119c-3c7d-ad26-01c3ce0d670a';
    public const ID_TAXATION = 'e40d8da3-27da-3a93-b6b2-cf0f14900ac5';
    public const ID_TRANSPORTATION = 'f77fa445-9f47-3c0d-a439-089a76d12f9c';

    public $import = ['table' => 'categories', 'connection' => 'fixtures'];
}
