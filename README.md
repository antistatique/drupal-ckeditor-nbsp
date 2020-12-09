# CKEditor Non-breaking space Plugin

Minimal module to insert a non-breaking space (`&nbsp;`)
into the content by pressing Ctrl+Space or using the provided button.

|       Travis-CI        |        Downloads        |         Releases         |
|:----------------------:|:-----------------------:|:------------------------:|
| [![Build Status](https://travis-ci.com/antistatique/drupal-ckeditor-nbsp.svg?branch=8.x-2.x)](https://travis-ci.com/antistatique/drupal-ckeditor-nbsp)  | [![Downloads](https://img.shields.io/badge/downloads-8.x--2.0-green.svg?style=flat-square)](https://ftp.drupal.org/files/projects/nbsp-8.x-2.0-alpha1.tar.gz) | [![Latest Stable Version](https://img.shields.io/badge/release-v2.0-blue.svg?style=flat-square)](https://www.drupal.org/project/nbsp/releases) |

## Uses

During content creation the author may add a non-breaking space (`&nbsp;`)
to prevent an automatic line break.
To avoid that a company’s 2-word name is split onto 2 separate lines.

As the non-breaking space is an invisible character,
they are highlighted in blue on the CKEditor.

## Installation

Install the module then follow the instructions
for installing the CKEditor plugins below.

## Configuration

Go to the [Text formats and editors](/admin/config/content/formats)
configuration page:, and for each text format/editor combo
where you want to use NBSP, do the following:

* Drag and drop the 'NBSP' button into the Active toolbar.
* Enable filter "Cleanup NBSP markup".
* if the "Limit allowed HTML tags and correct faulty HTML" filter is disabled
you dont have anything to do with this text format.
Otherwise, add the `class` attribute to `<span>` in the "allowed HTML tags"
field (Eg. `<span class>`).

## NBSP versions

The version `8.x-1.x` is not compatible with Drupal `8.8.x`.
Drupal `8.8.x` brings some breaking change with tests and so you
must upgrade to `8.x-2.x` version of **NBSP**.

## Which version should I use?

|Drupal Core|NBSP        |
|:---------:|:----------:|
|8.7.x      |1.x         |
|8.8.x      |2.x         |
|9.x        |2.x         |

## Dependencies

The Drupal 8 & Drupal 9 version of NBSP requires
[Editor](https://www.drupal.org/project/editor) and
[CKEditor](https://www.drupal.org/project/ckeditor).

## Supporting organizations

This project is sponsored by Antistatique. We are a Swiss Web Agency,
Visit us at [www.antistatique.net](https://www.antistatique.net) or
[Contact us](mailto:info@antistatique.net).
