<?php
class Migration extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function latest()
    {
        $this->load->library('migration', array(
            'migration_enabled' => true,
            'migration_path' => BASEPATH . '../vendor/migrations/',
        ));

        $this->debug('Current database version is ' . $this->migration->_get_version());
        $this->debug('Migrating');
        $latest = $this->migration->latest();
        if ($latest === true) {
            $this->debug('Database is up to date.');
        } elseif ($latest === false) {
            $this->debug('Ooups. Something went wrong. Check error logs.');
        } else {
            $this->debug('Update to version ' . $latest);
        }
        $this->debug('Finished');

    }

    private function debug($text)
    {
        echo date("Y-m-d H:i:s") . ' | Migration > ' . $text . "\n";
    }
}