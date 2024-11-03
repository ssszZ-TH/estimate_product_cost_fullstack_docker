จาก ER Diagram ที่แสดงไว้ มีความสัมพันธ์ระหว่างตารางต่างๆ ในฐานข้อมูลที่ต้องสร้างขึ้นโดยการใช้ Laravel Migration เพื่อจัดการโครงสร้างของฐานข้อมูลที่เกี่ยวข้อง ดังนั้นเราจะทำการสร้าง migrations สำหรับแต่ละตาราง พร้อมทั้งกำหนดความสัมพันธ์ระหว่างตารางด้วยการใช้ foreign keys ใน Laravel

ในการสร้าง migration เราสามารถใช้คำสั่ง `php artisan make:migration` เพื่อสร้าง migration files และแก้ไขตามรายละเอียดของโครงสร้างฐานข้อมูลที่แสดงใน diagram ได้ตามนี้:

1. **สร้างตาราง `costtype`**
2. **สร้างตาราง `geographicboundary`**
3. **สร้างตาราง `product`**
4. **สร้างตาราง `supplier`**
5. **สร้างตาราง `productfeature`**
6. **สร้างตารางหลัก `estimateproductcost`** พร้อมการกำหนด foreign keys ไปยังตารางที่เกี่ยวข้อง

### Step 1: สร้าง Migrations สำหรับแต่ละตาราง

```bash
php artisan make:migration create_costtype_table
php artisan make:migration create_geographicboundary_table
php artisan make:migration create_product_table
php artisan make:migration create_supplier_table
php artisan make:migration create_productfeature_table
php artisan make:migration create_estimateproductcost_table
```

### Step 2: แก้ไข Migration Files ตามโครงสร้างของ ER Diagram

ด้านล่างเป็นตัวอย่างการเขียน migration สำหรับแต่ละตาราง:

#### `create_costtype_table.php`
```php
public function up()
{
    Schema::create('costtype', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('code', 20)->unique();
        $table->string('name', 255)->unique();
    });
}
```

#### `create_geographicboundary_table.php`
```php
public function up()
{
    Schema::create('geographicboundary', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('code', 20)->unique();
        $table->string('name', 255)->unique();
    });
}
```

#### `create_product_table.php`
```php
public function up()
{
    Schema::create('product', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('code', 20)->unique();
        $table->string('name', 255)->unique();
    });
}
```

#### `create_supplier_table.php`
```php
public function up()
{
    Schema::create('supplier', function (Blueprint $table) {
        $table->string('id', 20)->primary();
        $table->string('code', 20)->unique();
        $table->string('name', 255)->unique();
    });
}
```

#### `create_productfeature_table.php`
```php
public function up()
{
    Schema::create('productfeature', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('code', 20)->unique();
        $table->string('description', 255);
    });
}
```

#### `create_estimateproductcost_table.php`
```php
public function up()
{
    Schema::create('estimateproductcost', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('code', 20)->unique();
        $table->date('fromdate');
        $table->date('thrudate')->nullable();
        $table->integer('cost');
        
        // Foreign keys
        $table->integer('costtypeid')->nullable();
        $table->foreign('costtypeid')->references('id')->on('costtype')->onDelete('set null');

        $table->integer('geographicboundaryid')->nullable();
        $table->foreign('geographicboundaryid')->references('id')->on('geographicboundary')->onDelete('set null');

        $table->string('supplierid', 20)->nullable();
        $table->foreign('supplierid')->references('id')->on('supplier')->onDelete('set null');

        $table->integer('productfeatureid')->nullable();
        $table->foreign('productfeatureid')->references('id')->on('productfeature')->onDelete('set null');

        $table->integer('productid')->nullable();
        $table->foreign('productid')->references('id')->on('product')->onDelete('set null');
    });
}
```

### Step 3: รัน Migration
หลังจากสร้าง migration files เสร็จแล้ว ให้รันคำสั่งด้านล่างเพื่อสร้างตารางในฐานข้อมูล:
```bash
php artisan migrate
```

### สรุป
- แต่ละตารางจะมีการตั้งค่า primary key, unique key และ foreign key ให้ตรงกับโครงสร้างใน ER Diagram
- ใช้ `nullable()` กับ foreign keys เพื่อให้สามารถตั้งค่าเป็น null ได้ในกรณีที่ไม่มีข้อมูล