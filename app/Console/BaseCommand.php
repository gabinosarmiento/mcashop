<?php

namespace App\Console;

use App\Events\AssistantCommandEvent;
use App\Events\AssistantProcessEvent;
use App\Models\CommandLogModel;
use App\Models\CommandModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use RuntimeException;

abstract class BaseCommand extends Command
{
    /**
     * Stores the current command progress counter.
     *
     * This value is increased every time the command reaches
     * a controlled checkpoint through checkCommand().
     *
     * @var int
     */
    protected int $progress = 0;

    /**
     * Stores the total command duration in seconds.
     *
     * @var int
     */
    public int $duration = 0;

    /**
     * Stores the command start timestamp.
     *
     * This value is used to calculate the real execution duration.
     *
     * @var int
     */
    protected int $start = 0;

    /**
     * Stores the total number of items expected to be processed.
     *
     * @var int
     */
    public int $total = 0;

    /**
     * Stores the total number of errors detected during execution.
     *
     * @var int
     */
    public int $errors = 0;

    /**
     * Starts or restarts a tracked command process.
     *
     * This method resets the command lifecycle fields, marks the
     * process as active, initializes the heartbeat and notifies the UI.
     *
     * @param int|null $id
     * @param string $message
     *
     * @return CommandModel
     */
    protected function startCommand(?int $id, string $message): CommandModel
    {
        $this->start = time();

        $command = CommandModel::updateOrCreate(
            ['id' => $id],
            [
                'name'        => $this->name,
                'label'       => $this->label,
                'description' => $this->description,
                'note'        => null,
                'progress'    => $this->progress,
                'duration'    => $this->duration,
                'total'       => $this->total,
                'errors'      => 0,
                'status'      => 'Activo',
                'heartbeat'   => now(),
                'finished_at' => null,
            ]
        );

        event(new AssistantProcessEvent($command));

        $this->logCommand($command, $message);

        return $command;
    }

    /**
     * Validates a service response used by the command.
     *
     * If the service returns an error key, the command is stopped
     * immediately and marked as failed.
     *
     * @param CommandModel $command
     * @param array $response
     * @param string $service
     *
     * @return void
     */
    protected function serviceCommand(CommandModel $command, array $response, string $service): void
    {
        $this->logCommand($command, $service);

        if (isset($response['error'])) {
            $context = null;

            if (isset($response['request'])) {
                $context = $response['request'];
            }

            $this->stopCommand($command, $response['error'], $context, 'Fallido');
        }
    }

    /**
     * Updates the command heartbeat, progress and duration.
     *
     * This method also detects manual cancellation requests made
     * from the UI or controller by checking the current database status.
     *
     * @param CommandModel $command
     *
     * @return void
     */
    protected function checkCommand(CommandModel $command): void
    {
        $command->refresh();

        if ($command->status === 'Cancelado') {
            $this->stopCommand($command, 'Comando cancelado', 'Comando cancelado por el administrativo', 'Cancelado');
        }

        $this->progress++;

        $this->duration = time() - $this->start;

        $progress = intval(($this->progress / $this->total) * 100);

        $command->update([
            'progress'  => $progress,
            'duration'  => $this->duration,
            'heartbeat' => now(),
        ]);

        $command->refresh();

        event(new AssistantProcessEvent($command));
    }

    /**
     * Stops the command execution and marks the process with a final status.
     *
     * This method is used for failed and cancelled processes. It stores the
     * final note, completion timestamp, sends UI updates and throws an
     * exception to stop the current command flow.
     *
     * @param CommandModel $command
     * @param string $note
     * @param string|null $context
     * @param string $status
     *
     * @return void
     */
    protected function stopCommand(CommandModel $command, string $note, ?string $context = null, string $status = 'Fallido'): void
    {
        $command->update([
            'duration'    => $this->duration,
            'total'       => $this->total,
            'errors'      => $this->errors,
            'note'        => $note,
            'status'      => $status,
            'finished_at' => now(),
        ]);

        if ($status === 'Fallido') {
            event(new AssistantProcessEvent($command));
        }

        $this->logCommand($command, $note, $context, 'error');

        $this->warn('Process cancelled');

        throw new RuntimeException($note);
    }

    /**
     * Completes the command successfully.
     *
     * This method stores the final duration, totals, error counter,
     * completion timestamp and notifies the UI.
     *
     * @param CommandModel $command
     *
     * @return void
     */
    protected function completeCommand(CommandModel $command): void
    {
        $this->duration = time() - $this->start;

        $command->update([
            'duration'    => $this->duration,
            'total'       => $this->total,
            'errors'      => $this->errors,
            'status'      => 'Completado',
            'finished_at' => now(),
        ]);

        event(new AssistantProcessEvent($command));

        $this->logCommand($command, 'Proceso finalizado correctamente');

        $this->info('Process completed successfully.');
    }

    /**
     * Creates a structured command log entry.
     *
     * The log is stored in the database and immediately broadcasted
     * to keep the command console synchronized in real time.
     *
     * @param CommandModel $command
     * @param string $message
     * @param string|null $context
     * @param string $type
     *
     * @return void
     */
    protected function logCommand(CommandModel $command, string $message, ?string $context = null, string $type = 'info'): void
    {
        $message = sprintf('[%s][%s] %s', date('H:i:s'), $this->label, $message);

        $log = CommandLogModel::create([
            'command_id' => $command->id,
            'message'    => $message,
            'context'    => $context,
            'type'       => $type,
        ]);

        event(new AssistantCommandEvent($log));
    }

    /**
     * Adds a dedicated file logger for command execution.
     *
     * This allows command logs to be written into a separated daily file
     * without replacing the default Laravel logging configuration.
     *
     * @return void
     */
    protected function loggingCommand(): void
    {
        $logFile = storage_path('logs/command-' . date('Y-m-d') . '.log');

        $handler = new StreamHandler($logFile, Logger::DEBUG);

        $logger = Log::getLogger();

        $logger->pushHandler($handler);
    }
}