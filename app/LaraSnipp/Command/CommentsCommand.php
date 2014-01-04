<?php

namespace LaraSnipp\Command;

use Config;
use Illuminate\Console\Command;
use Snippet;
use Symfony\Component\Console\Input\InputOption;
use URL;

class CommentsCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = "larasnipp:comments";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Fetches comment counts from Disqus.";

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
    $this->info("Getting comment counts...");

    $key    = "0mFcWkCCymiSfXfrPDtUNX7RxMpLwFYcZCFwdrJxIjyOXiEBHoMiqd7XY18M6GlD";
    $forum  = "laravel-snippets";
    $domain = $this->option("domain");

    $snippets = Snippet::orderBy("updated_comments_at", "asc")->take(50)->get();

    foreach ($snippets as $snippet)
    {
      $thread = URL::route("snippet.getShow", $snippet->slug);
      $thread = str_replace(Config::get("app.url"), $domain, $thread);

      $endpoint = "http://disqus.com/api/3.0/threads/details.json?api_key=".urlencode($key)."&forum=".$forum."&thread:link=".urlencode($thread);

      $session = curl_init($endpoint);

      curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($session);
      curl_close($session);

      $data = json_decode($response);

      if ($data->code == 0)
      {
        $snippet->comments = $data->response->posts;
        $snippet->updated_comments_at = date("Y-m-d H:i:s");
        $snippet->save();

        $this->info($thread);
      }
    }
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return [];
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return [
      ["domain", null, InputOption::VALUE_REQUIRED, "Domain against which to draw comment counts.", Config::get("app.url")]
    ];
  }

}