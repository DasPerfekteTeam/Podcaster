Podcasting Plugin for Neos
==========================

Provides podcasting functionality for Neos and integrates the [Podlove Web Player](http://podlove.org/podlove-web-player/).


Installation
------------

`composer require dasperfekteteam/podcaster`

This plugin requires Neos from 3.0 upwards.

The player needs jQuery and the provided JavaScript to work.
For ease of use a Fusion snippet is available to include these:

`page.head.podcaster = DasPerfekteTeam.Podcaster:PageHeaderIncludes`

By default this will not load jQuery and expects an existing, loaded jQuery.
You can enable loading of jQuery like this:

    page.head.podcaster = DasPerfekteTeam.Podcaster:PageHeaderIncludes {
        loadJQuery = true
    }

Quickstart
----------

This package provides two page types:

#### Podcast ####

This is the home of a new podcast (eg. a set of episodes with the same topic). 
Many websites will have a single podcast, but functionality is provided to have multiple podcasts in one Neos Site.
 
All meta data for the podcast is derived from this page and it's also the entry point for the podcast feed.

#### Episode ####

This is the page for a single episode for the podcast. It holds all metadata for the episode and can contain
additional information about it. In backend it will render an additional content area for `Chapters` which
will create the chapter list for the web player.

You can upload your episode in multiple audio formats which defines which kind of feeds you can access.


### Feeds ###

The main feature is generation of RSS feeds for podcasts. A default route is enabled with installation of this package,
which can produce feeds for any `Podcast` and audio format on your site.

The easiest is, if your `Podcast` page is the homepage of your site, then the URL for a feed is:

`http://domain/podcast.{audioformat}.xml` eg. `https://www.das-perfekte-team.de/podcast.mp3.xml`

If your `Podcast` starts on a sub page, the URL would be:

`http://domain/path/to/your/page.podcast.{audioformat}.xml`

The `audioformat` is always the file extension of your episodes files, 
so if you provide your podcast as `mp3`, `ogg` and `m4a` these three have their own feed.
 
Feed rendering can be customized by Fusion and Template changes.


### To be continued ###

More features and documentation should follow at a later stage. 
More integrations to services and Neos is planned for the future.


