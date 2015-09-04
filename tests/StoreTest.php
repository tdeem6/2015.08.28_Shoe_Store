<?php

    /**
    * @backupGlobals disabled
    * @backupAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function testGetStoreName()
        {
            //Arrange
            $store_name = "Payless";
            $test_store = new Store($store_name);

            //Act
            $result = $test_store->getStoreName();

            //Assert
            $this->assertEquals($store_name, $result);

        }

        function testSetStoreName()
        {
            //Arrange
            $store_name = "Payless";
            $test_store = new Store($store_name);

            //Act
            $test_store->setStoreName($store_name);
            $result = $test_store->getStoreName();

            //Assert
            $this->assertEquals($store_name, $result);
        }

        function test_getId()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            // $test_store->save();

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //Arrange
            $store_name = "Nike Outlet";
            // $id = 1;
            $test_store = new Store($store_name, $id = null);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $store_name = "Nike Outlet";
            // $id = 1;
            $store_name2 = "Prada";
            // $id2 = 2;
            $test_store = new Store($store_name, $id = null);
            $test_store->save();
            $test_store2 = new Store($store_name2, $id = null);
            $test_store2->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDelete()
        {
            //Arrange
            $store_name = "Payless";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $id2 = 2;
            $test_brand = new Brand($brand_name, $id2);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->delete();

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "Prada";
            $id2 = 2;
            $test_store2 = new Store($store_name2, $id2);
            $test_store2->save();

            //Act
            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "Prada";
            $id2 = 2;
            $test_store2 = new Store($store_name2, $id2);
            $test_store->save();

            //Act
            $result = Store::find($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $result);
        }

        function testUpdate()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $new_store_name = "Prada";

            //Act
            $test_store->update($new_store_name);

            //Assert
            $result = $test_store->getStoreName();
            $this->assertEquals($new_store_name, $result);
        }

        function testDeleteStore()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "Prada";
            $id2 = 2;
            $test_store2 = new Store($store_name2, $id2);
            $test_store2->save();

            //Act
            $test_store->delete();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([$test_store2], $result);
        }

        function testGetBrands()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            // $test_store_id = $test_store->getId();

            $brand_name = "Nike";
            $id2 = 2;
            $test_brand = new Brand($brand_name, $id2);
            $test_brand->save();


            $brand_name2 = "Converse";
            $id3 = 3;
            $test_brand2 = new Brand($brand_name2, $id3);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            // //Act
            // $result = $test_store->getBrands();
            //
            // //Assert
            // $this->assertEquals([$test_brand, $test_brand2], $result);
            $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
        }

        function testAddBrand()
        {
            //Arrange
            $store_name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $id2 = 2;
            $test_brand = new Brand($brand_name, $id2);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);

            //Assert
            // $result = $test_store->getBrands();
            // $this->assertEquals([$test_brand], $result);
            $this->assertEquals($test_store->getBrands(), [$test_brand]);
        }
    }
?>
