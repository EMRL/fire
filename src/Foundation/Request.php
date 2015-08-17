<?php

namespace Fire\Foundation;

use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;
use Fire\Contracts\Model\Page\PageRepository as PageRepositoryContract;
use Fire\Model\Page\PagePostType;
use Fire\Foundation\Collection;

class Request
{
    protected $postRepository;

    protected $pageRepository;

    protected $errors404 = [];

    public function __construct(
        PostRepositoryContract $postRepository,
        PageRepositoryContract $pageRepository
    ) {
        $this->postRepository = $postRepository;
        $this->pageRepository = $pageRepository;

        add_action('template_redirect', function () { $this->resolve404s(); });
        add_action('template_redirect', function () { $this->setCurrentEntities(); });
    }

    public function resolveAs404()
    {
        foreach (func_get_args() as $arg) {
            if ( ! is_array($arg)) {
                $arg = [$arg];
            }

            $this->errors404[] = $arg;
        }
    }

    protected function resolve404s()
    {
        global $wp_query;

        $error = false;

        foreach ($this->errors404 as $args) {
            $test = array_shift($args);

            if (call_user_func_array($test, $args)) {
                $error = true;
                break;
            }
        }

        if ($error) {
            http_response_code(404);
            $wp_query->init();
            $wp_query->parse_query(['post' => 0]);
            $wp_query->set_404();
        }
    }

    protected function setCurrentEntities()
    {
        global $wp_query;

        if ($post = $wp_query->post) {
            if ($post->post_type === PagePostType::TYPE) {
                $this->pageRepository->setCurrentPage($this->pageRepository->pageOfId($post->ID));
            } else {
                $this->postRepository->setCurrentPost($this->postRepository->postOfId($post->ID));
            }
        }

        $collection = new Collection;

        if ($posts = $wp_query->posts) {
            foreach ($posts as $post)
            {
                $collection->push($this->postRepository->postOfId($post->ID));
            }
        }

        $this->postRepository->setCurrentPosts($collection);
    }
}
