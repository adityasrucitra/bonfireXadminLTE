<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Initial_tables extends Migration
{
    private $permissionValues = array(
        array('name' => 'Bonfire.Items.View', 'description' => 'View the items.', 'status' => 'active'),
        array('name' => 'Bonfire.Items.Delete', 'description' => 'Delete items', 'status' => 'active'),
    );

    private $permittedRoles = array(
        'Administrator',
    );

    /**
     * The definition(s) for the table(s) used by this migration.
     * @type array
     */
    private $tables = array(
        'items' => array(
            'primaryKey' => 'id',
            'fields' => array(
                'id' => array(
                    'type'           => 'bigint',
                    'constraint'     => 20,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ),
                'itemID' => array(
                    'type'       => 'bigint',
                    'constraint' => 20,
                    'null'       => false,
                ),
                'shopID' => array(
                    'type'       => 'bigint',
                    'constraint' => 20,
                    'null'       => false,
                ),
                'name' => array(
                    'type'       => 'text',
                    // 'constraint' => 20,
                    'null'       => false,
                ),
                'alias' => array(
                    'type'       => 'text',
                    // 'constraint' => 20,
                    'null'       => false,
                ),
                'price' => array(
                    'type'       => 'float',
                    'constraint' => 20,
                    'null'       => false,
                ),
                'priceCurrency' => array(
                    'type'       => 'varchar',
                    'constraint' => 8,
                    'null'       => false,
                ),
                'lastUpdatePrice' => array(
                    'type'       => 'datetime',
                    // 'constraint' => 20,
                    'null'       => false,
                ),
                'description' => array(
                    'type'       => 'text',
                    // 'constraint' => 20,
                    'null'       => false,
                ),
                'minOrder' => array(
                    'type'       => 'int',
                    'constraint' => 4,
                    'null'       => false,
                ),
                'maxOrder' => array(
                    'type'       => 'int',
                    'constraint' => 4,
                    'null'       => false,
                ),
                'status' => array(
                    'type'       => 'varchar',
                    'constraint' => 16,
                    'null'       => false,
                ),
                'weight' => array(
                    'type'       => 'float',
                    'constraint' => 16,
                    'null'       => false,
                ),
                'weightUnit' => array(
                    'type'       => 'varchar',
                    'constraint' => 16,
                    'null'       => false,
                ),
                'condition' => array(
                    'type'       => 'varchar',
                    'constraint' => 8,
                    'null'       => false,
                ),
                'url' => array(
                    'type'       => 'varchar',
                    'constraint' => 255,
                    'null'       => false,
                ),
                'sku' => array(
                    'type'       => 'varchar',
                    'constraint' => 16,
                    'null'       => true,
                ),
                'gtin' => array(
                    'type'       => 'varchar',
                    'constraint' => 16,
                    'null'       => true,
                ),
                'isKreasiLokal' => array(
                    'type'       => 'tinyint',
                    'constraint' => 1,
                    'null'       => false,
                ),
                'isMustInsurance' => array(
                    'type'       => 'tinyint',
                    'constraint' => 1,
                    'null'       => false,
                ),
                'isEligibleCOD' => array(
                    'type'       => 'tinyint',
                    'constraint' => 1,
                    'null'       => false,
                ),
                'isLeasing' => array(
                    'type'       => 'tinyint',
                    'constraint' => 1,
                    'null'       => false,
                ),
                'catalogID' => array(
                    'type'       => 'int',
                    'constraint' => 16,
                    'null'       => true,
                ),
                'needPrescription' => array(
                    'type'       => 'tinyint',
                    'constraint' => 1,
                    'null'       => false,
                ),               
                'created_on' => array(
                    'type' => 'datetime',
                    'null' => false,
                ),
                'modified_on' => array(
                    'type'    => 'datetime',
                    'null'    => true,
                    'default' => '0000-00-00 00:00:00',
                ),
                'deleted' => array(
                    'type'       => 'tinyint',
                    'constraint' => 1,
                    'null'       => false,
                    'default'    => 0,
                ),
            ),
        ),
    );

    /**
     * Install the blog tables
     *
     * @return void
     */
    public function up()
    {
        $this->load->dbforge();

        // Install the table(s) in the database.
        foreach ($this->tables as $tableName => $tableDef) {
            $this->dbforge->add_field($tableDef['fields']);
            $this->dbforge->add_key($tableDef['primaryKey'], true);
            $this->dbforge->create_table($tableName);
        }

        // Create the Permissions.
        $this->load->model('permissions/permission_model');
        $permissionNames = array();
        foreach ($this->permissionValues as $permissionValue) {
            $this->permission_model->insert($permissionValue);
            $permissionNames[] = $permissionValue['name'];
        }

        // Assign them to the permitted roles.
        $this->load->model('role_permission_model');
        foreach ($this->permittedRoles as $permittedRole) {
            foreach ($permissionNames as $permissionName) {
                $this->role_permission_model->assign_to_role($permittedRole, $permissionName);
            }
        }
    }

    /**
     * Remove the blog tables
     *
     * @return void
     */
    public function down()
    {
        // Remove the data.
        $this->load->dbforge();
        foreach ($this->tables as $tableName => $tableDef) {
            $this->dbforge->drop_table($tableName);
        }

        // Remove the permissions.
        $this->load->model('roles/role_permission_model');
        $this->load->model('permissions/permission_model');

        $permissionKey = $this->permission_model->get_key();
        foreach ($this->permissionValues as $permissionValue) {
            $permission = $this->permission_model->select($permissionKey)
                ->find_by('name', $permissionValue['name']);
            if ($permission) {
                // permission_model's delete method calls the role_permission_model's
                // delete_for_permission method.
                $this->permission_model->delete($permission->{$permissionKey});
            }
        }
    }
}
