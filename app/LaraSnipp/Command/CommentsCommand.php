<?php

namespace LaraSnipp\Command;

use Config;
use Illuminate\Console\Command;
use Snippet;

class CommentsCommand extends Command
{
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

        $key = Config::get("disqus.key");
        $forum = Config::get("disqus.shortname");
        $endpoint = Config::get("disqus.endpoint");

        $snippets = Snippet::orderBy("updated_comments_at", "asc")->take(50)->get();

        foreach ($snippets as $snippet) {
            $link = sprintf($endpoint, $key, $forum, "snippet-" . $snippet->slug);
            $session = curl_init($link);

            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($session);
            curl_close($session);

            $data = json_decode($response);

            if ($data->code == 0) {
                $snippet->comments = $data->response->posts;
                $snippet->updated_comments_at = date("Y-m-d H:i:s");
                $snippet->save();

                $this->info($link);
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
        return [];
    }

}
