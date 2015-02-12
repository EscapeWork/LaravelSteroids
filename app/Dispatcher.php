<?php namespace EscapeWork\LaravelSteroids\Dispatcher

use Illuminate\Bus\Dispatcher as LaravelDispatcher;

class Dispatcher extends LaravelDispatcher {

    /**
     * Pipes for a specific command
     */
    protected $commandPipes;

    /**
     * Returning the pipes for $commadn
     * @param $command wanted the pipes for
     */
    protected function pipes($command = null)
    {
        $command = get_class($command);

        if (! isset($this->commandPipes[$command])) {
            return $this->pipes;
        }

        return array_merge($this->pipes, $this->commandPipes[$command]);
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     * Using pipes method to return the pipes
     *
     * @override
     * @param  mixed  $command
     * @param  \Closure|null  $afterResolving
     * @return mixed
     */
    public function dispatchNow($command, Closure $afterResolving = null)
    {
        return $this->pipeline->send($command)->through($this->pipes($command))->then(function($command) use ($afterResolving)
        {
            if ($command instanceof SelfHandling)
                return $this->container->call([$command, 'handle']);

            $handler = $this->resolveHandler($command);

            if ($afterResolving)
                call_user_func($afterResolving, $handler);

            return call_user_func(
                [$handler, $this->getHandlerMethod($command)], $command
            );
        });

    }

    /**
     * Set the pipes a command should be piped through before dispatching.
     *
     * @param  string  $command
     * @param  array  $pipes
     * @return $this
     */
    public function pipeCommandThrough($command, $pipes)
    {
        $this->commandPipes[$command] = $pipes;

        return $this;
    }


}
