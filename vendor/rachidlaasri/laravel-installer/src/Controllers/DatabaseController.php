<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use RachidLaasri\LaravelInstaller\Helpers\DatabaseManager;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        // $response = $this->databaseManager->migrateAndSeed();

        try {
            // Run sql modifications
            $sql_path = storage_path('app/public/restro_saas.sql');

            if (file_exists($sql_path)) {
                DB::unprepared(file_get_contents($sql_path));
            }
    
            $response = array(
                "status" => "success",
                "message" => "Installation Finished",
                "dbOutputLog" => "Application has been successfully installed.",
            );
        } catch (\Throwable $th) {
            $response = array(
                "status" => "error",
                "message" => "Something went wrong",
                "dbOutputLog" => "Database migration error",
            );
        }

        return redirect()->route('LaravelInstaller::final')
                         ->with(['message' => $response]);
    }
}
