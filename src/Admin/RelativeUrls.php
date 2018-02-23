<?php

namespace Fire\Admin;

class RelativeUrls
{
    /**
     * The current domain
     *
     * @var string
     */
    protected $domain;

    /**
     * Sets up hooks to remove the domain from content before saving to the
     * database. This makes migrations simple as there are much less absolute
     * paths in the database.
     *
     * Not all absolute paths are fixed, some plugins and cached settings could
     * potentially have full URLs still, but we fix the ones that matter most.
     */
    public function __construct()
    {
        // Probably running in CLI mode
        if ( ! isset($_SERVER['SERVER_NAME'])) {
            return;
        }

        $this->domain = $_SERVER['SERVER_NAME'];

        // Posts
        add_filter('wp_insert_post_data', function ($data, $post) {
            $data['post_content'] = $this->replaceDomain($data['post_content']);
            $data['post_excerpt'] = $this->replaceDomain($data['post_excerpt']);
            $data['guid']         = $this->replaceDomain($data['guid']);

            return $data;
        }, null, 2);

        add_action('wp_insert_post', function ($id, $post, $update) {
            global $wpdb;

            if ($post->post_type !== 'revision' and $post->post_status !== 'auto-draft') {
                return;
            }

            if (strpos($post->guid, $this->domain) !== false) {
                $guid = $this->replaceDomain($post->guid);

                $wpdb->update($wpdb->posts, ['guid' => $guid], ['ID' => $id]);
            }
        }, null, 3);

        // Meta
        add_actions('added_post_meta updated_post_meta', function ($id, $objectId, $key, $value) {
            $this->replaceDomainInMeta('post', $id, $objectId, $key, $value);
        }, null, 4);

        add_actions('added_user_meta updated_user_meta', function ($id, $objectId, $key, $value) {
            $this->replaceDomainInMeta('user', $id, $objectId, $key, $value);
        }, null, 4);

        add_actions('added_comment_meta updated_comment_meta', function ($id, $objectId, $key, $value) {
            $this->replaceDomainInMeta('comment', $id, $objectId, $key, $value);
        }, null, 4);

        // Options
        add_action('added_option', function ($option, $value) {
            $this->replaceDomainInOption($option, $value);
        }, null, 2);

        add_action('updated_option', function ($option, $old_value, $value) {
            $this->replaceDomainInOption($option, $value);
        }, null, 3);

        // Feeds need absolute URLs
        add_filter('the_excerpt_rss', function ($excerpt) {
            return $this->relativeToAbsolute($excerpt);
        });

        add_filter('the_content_feed', function ($content) {
            return $this->relativeToAbsolute($content);
        });
    }

    /**
     * Replace the domain in meta tables
     *
     * @param  string   $type
     * @param  integer  $id
     * @param  integer  $objectId
     * @param  string   $key
     * @param  mixed    $value
     */
    public function replaceDomainInMeta($type, $id, $objectId, $key, $value)
    {
        global $wpdb;

        $table  = _get_meta_table($type);
        $column = sanitize_key($type.'_id');

        $newValue = $this->replaceDomainRecursive($value);

        if ($value !== $newValue) {
            $data = ['meta_value' => maybe_serialize($newValue)];

            $where = [
                $column      => $objectId,
                'meta_key'   => $key,
                'meta_value' => maybe_serialize($value),
            ];

            $wpdb->update($table, $data, $where);
        }
    }

    /**
     * Replace the domain in options table
     *
     * @param  string  $option
     * @param  mixed   $value
     */
    public function replaceDomainInOption($option, $value)
    {
        global $wpdb;

        if ( ! $wpdb instanceof wpdb) {
            return;
        }

        $newValue = $this->replaceDomainRecursive($value);

        if ($value !== $newValue) {
            $serialized = maybe_serialize($value);

            $wpdb->update($wpdb->options, ['option_value' => $serialized], ['option_name' => $option]);

            wp_cache_set($option, $serialized, 'options');
        }
    }

    /**
     * Recursively replace the domain for cases where options have arrays
     * of arrays where the domain could be anywhere
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function replaceDomainRecursive($value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->replaceDomainRecursive($v);
            }
        } elseif ( ! is_object($value)) {
            if (strpos($value, $this->domain) !== false) {
                $value = $this->replaceDomain($value);
            }
        }

        return $value;
    }

    /**
     * Convert all relative URLs in a string to absolute URLs
     *
     * @param  string  $string
     * @return string
     */
    protected function relativeToAbsolute($string)
    {
        // I'm not proud of this, but that's WordPress for ya :)
        $string = preg_replace('/(src|href)=(["\'])\/(?!\/)/', '$1=$2'.url().'/', $string);

        $string = preg_replace_callback('/srcset=(["\'])([^"\']+)\\1/', function ($matches) {
            if (isset($matches[2])) {
                $parts = array_map('trim', explode(',', $matches[2]));

                foreach ($parts as $key => $part) {
                    if ($part[0] === '/' and $part[1] !== '/') {
                        $parts[$key] = url($part);
                    }
                }

                return 'srcset='.$matches[1].implode(', ', $parts).$matches[1];
            }

            return $matches[0];
        }, $string);

        return $string;
    }

    /**
     * Replace the domain in a string
     *
     * @param  string  $value
     * @return string
     */
    public function replaceDomain($value)
    {
        $normal_urls = 'http://'.$this->domain;
        $secure_urls = 'https://'.$this->domain;

        $value = str_replace($normal_urls, '', $value);
        $value = str_replace($secure_urls, '', $value);

        return $value;
    }
}
