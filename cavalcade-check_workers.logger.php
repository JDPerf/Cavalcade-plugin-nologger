<?php

// Example Cavalcade Runner plugin that disables logging to the database
// Should be loaded from PHP file specified by CAVALCADE_CONFIG variable

namespace Custom\Cavalcade;

use HM\Cavalcade\Runner\Hooks;
use HM\Cavalcade\Runner\Logger;
use HM\Cavalcade\Runner\Job;
use HM\Cavalcade\Runner\Runner;

// Ensure the Cavalcade Runner is loaded.
if ( ! class_exists( Runner::class ) ) {
    error_log( 'Cavalcade Runner is not loaded.' );
    return;
}

// Revise the following for other hooks or your own actual logger

// Register the custom logger via the Runner's hooks system.
Runner::instance()->hooks->register( 'Runner.check_workers.logger', function () {
    error_log( 'Cavalcade: Custom logger registered.' );

    // Create and return a custom logger.
    return new class extends Logger {
        public function __construct() {
            // Do not call the parent constructor; no database interaction needed.
            error_log( 'Cavalcade: Custom logger initialized.' );
        }

        public function log_job_failed( Job $job, $message = '' ) {
            // Disable logging of job failures
            error_log( "Cavalcade: Job failed logging disabled for job ID {$job->id}" );
        }

        public function log_job_completed( Job $job, $message = '' ) {
            // Disable logging of completed jobs
            error_log( "Cavalcade: Job completed logging disabled for job ID {$job->id}" );
        }
    };
} );