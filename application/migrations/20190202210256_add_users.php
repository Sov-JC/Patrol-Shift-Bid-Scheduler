<?php

class Migration_Add_users extends CI_Migration {
	public function up() {
		$this->load->dbforge();
		$this->load->model('user_model');

		$this->dbforge->add_field([
			'id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'unique' => TRUE
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'is_admin' => [
				'type' => 'BOOL',
			]
		]);

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');

		$this->user_model->edit_user([
            'id' => 100000,
			'email' => 'admin@example.com',
			'password' => password_hash('admin', PASSWORD_DEFAULT),
			'first_name' => 'Admin',
			'last_name' => 'User',
			'is_admin' => TRUE,
		]);
	}

	public function down() {
		$this->dbforge->drop_table('users');
	}
}
