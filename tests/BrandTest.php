<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";
    $server = 'mysql:host=localhost;dbame=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function testGetBrandName()
        {
          //Arrange
          $brand_name = "Nike";
          $test_brand = new Brand($brand_name);

          //Act
          $result = $test_brand->getBrandName();

          //Assert
          $this->assertEquals($brand_name, $result);
        }

        function testSetBrandName()
        {
            //Arrange
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);

            //Act
            $test_brand->setBrandName($brand_name);
            $result = $test_brand->getBrandName();

            //Assert
            $this->assertEquals($brand_name, $result);
        }

        function testGetId()
        {
            //Arrange
            $id = 1;
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name, $id);

            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $brand_name = "Nike";
            $id = null;
            $test_brand = new Brand($brand_name, $id = null);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand], $result);
        }

        function testGetAll()
        {
            //Arrange
            $brand_name = "Nike";
            $id = null;
            $test_brand = new Brand($brand_name, $id = null);
            $test_brand->save();

            $brand_name2 = "Puma";
            $test_brand2 = new Brand($brand_name2, $id = null);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $brand_name = "Nike";
            $id = null;
            $test_brand = new Brand($brand_name, $id = null);
            $test_brand->save();

            $brand_name2 = "Puma";
            $test_brand2 = new Brand($brand_name2, $id = null);
            $test_brand2->save();

            //Act
            Brand::deleteAll();

            //Assert
            $result = Brand::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $brand_name = "Nike";
            $id = null;
            $test_brand = new Brand($brand_name, $id = null);
            $test_brand->save();

            $brand_name2 = "Puma";
            $test_brand2 = new Brand($brand_name2, $id = null);
            $test_brand2->save();

            //Act
            $result = Brand::find($test_brand2->getId());

            //Assert
            $this->assertEquals($test_brand2, $result);
        }

        function testAddStore()
        {
            //Arrange
            $brand_name = "Nike";
            $id = null;
            $test_brand = new Brand($brand_name, $id = null);
            $test_brand->save();

            $store_name = "Nike Outlet";
            $test_store = new Store($store_name, $id = null);
            $test_store->save();

            //Act
            $test_brand->addStore($test_store);

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([$test_store], $result);
        }

        function testGetStores()
        {
            //Arrange
            $brand_name = "Nike";
            $id = null;
            $test_brand = new Brand($brand_name, $id = null);
            $test_brand->save();

            $store_name = "Nike Outlet";
            $test_store = new Store($store_name, $id = null);
            $test_store->save();

            $store_name2 = "Prada";
            $test_store2 = new Store($store_name2, $id = null);
            $test_store2->save();

            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);

            //Act
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }
  }
?>
