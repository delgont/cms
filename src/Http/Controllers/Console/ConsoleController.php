<?php

namespace Delgont\Cms\Http\Controllers\Console;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;

use Illuminate\Support\Facades\Artisan;



class ConsoleController extends Controller
{
   public function index()
   {
      return view('delgont::commands.index');
   }
   public function run(Request $request)
   {
      $command = $this->findCommandOrFail($request->command);

      $rules = $this->buildRules($command);
      $data = request()->validate($rules);

      $data = array_filter($data);
      $options = array_keys($command->getDefinition()->getOptions());

      $params = [];

      foreach ($data as $key => $value) {

          if (in_array($key, $options))
              $key = "--{$key}";

          $params[$key] = $value;
      }

      $output = new BufferedOutput(BufferedOutput::VERBOSITY_NORMAL, true);
      try {
          $status = Artisan::call($command->getName(), $params, $output);
          $output = $output->fetch();
      } catch (\Exception $exception) {
          $status = $exception->getCode() ?? 500;
          $output = $exception->getMessage();
      }

      $res = [
          'status' => $status,
          'output' => $output,
          'command' => $command->getName()
      ];

      return back()->with('res');
   }


   protected function findCommandOrFail(string $name): Command {
      $commands = Artisan::all();

      if (!in_array($name, array_keys($commands)))
          abort(404);

      return $commands[$name];
  }


  protected function commandToArray($command): ?array {
   if ($command === null)
       return  null;

   if (!$command instanceof Command)
       return [
           'name' => $command,
           'error' => 'Not found'
       ];

   return [
       'name' => $command->getName(),
       'description' => $command->getDescription(),
       'synopsis' => $command->getSynopsis(),
       'arguments' => $this->argumentsToArray($command),
       'options' => $this->optionsToArray($command),
   ];
  }

  protected function argumentsToArray(Command $command): ?array {
   $definition = $command->getDefinition();
   $arguments = array_map(function (InputArgument $argument) {
       return [
           'title' => Str::of($argument->getName())->snake()->replace('_', ' ')->title()->__toString(),
           'name' => $argument->getName(),
           'description' => $argument->getDescription(),
           'default' => empty($default = $argument->getDefault()) ? null : $default,
           'required' => $argument->isRequired(),
           'array' => $argument->isArray(),
       ];
   }, $definition->getArguments());

   return empty($arguments) ? null : $arguments;
  }

  protected function optionsToArray(Command $command): ?array {
   $definition = $command->getDefinition();

   $options = array_map(function (InputOption $option) {
       return [
           'title' => Str::of($option->getName())->snake()->replace('_', ' ')->title()->__toString(),
           'name' => $option->getName(),
           'description' => $option->getDescription(),
           'shortcut' => $option->getShortcut(),
           'required' => $option->isValueRequired(),
           'array' => $option->isArray(),
           'accept_value' => $option->acceptValue(),
           'default' => empty($default = $option->getDefault()) ? null : $default,
       ];
   }, $definition->getOptions());

   return empty($options) ? null : $options;
  }

  protected function buildRules(Command $command) {
   $rules = [];

   foreach ($command->getDefinition()->getArguments() as $argument) {
       $rules[$argument->getName()] = [
           $argument->isRequired() ? 'required' : 'nullable',
       ];
   }

   foreach ($command->getDefinition()->getOptions() as $option) {
       $rules[$option->getName()] = [
           $option->isValueRequired() ? 'required' : 'nullable',
           $option->acceptValue() ? ($option->isArray() ? 'array' : 'string') : 'bool',
       ];
   }

   return $rules;
  }
  
}
