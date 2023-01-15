<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
<meta charset="utf-8">
<title>MD notepad</title>
<link rel="stylesheet" href="/css/spectre.css">

<style>
body {
    font-family: Geneva, sans-serif;
    color: #444444;
}
H1 {
  font-weight: 600;
  margin-top: 0;
  padding: 0.5em;
  color: darkgreen;
  text-align: center;
  border-bottom: solid 2px darkgreen;
}
H2, H3, H4, H5, H6 {
    margin-top: 2.5em;
}
strong {
  color: darkgreen;
}
a {
  color: #1060B0;
  text-decoration: none;
}
a:link {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

a:active {
  text-decoration: underline;
}
th {
    background-color: #777777;
    color: #FFFFFF;
    padding: 0.5em;
    font-size: 90%;
}
HR {
  color: darkgreen;
}
textarea {
  width: 100%;
  height: 40em;
  font-family: monospace;
  font-size: 110%;
  border: solid thin lightgray;
  padding: 0.75em;
}
textarea:focus {
  outline: none !important;
  border: solid thin red;
  box-shadow: 2px 2px 4px #CECECE;
}
div.editor {
  width: 100%;
}
div.buttons {
  width: 100%;
  text-align: right;
  padding: 0.4em;
}
input {
  width: 200px;
  padding: 0.4em;
  background-color: #BCDCF4;
  border-width: thin;
}
.search input {
  background-color: transparent;
  margin: 0 0 10px 0;
  padding: 0.2em;
  font-size: 100%;
  border: solid 1px #BBBBBB;
}
img {
    max-width: 100%;
    max-height: 100%;
}
pre {
    width: inherit;
    padding: 0.6em 0.6em 1.2em 0.6em;
    color: #000000;
    background-color: #EEEEEE;
    font-family: monospace;
    line-height: 1.3em;
    overflow: scroll;
    border: solid 1px #BBBBBB;
    box-shadow: 4px 4px 4px #BBBBBB;
}
code {
    font-size: 130%;
    background-color: #EEEEEE;
    padding: 0 0.25em 0 0.25em;
    color: #000000;
}
pre code {
    padding: 0;
    background-color: none;
    font-size: 110%;
}

div.set-mode {
    border: none;
    white-space: nowrap;
    padding: 0;
}
div.mode-btn {
    display: inline-block;
    border: solid 1px #555;
    font-size: 120%;
    text-align: center;
    background-color: #888;
    width: 42px;
    margin: 0 0 0 0;
}
span.button {
    background-color: #888;
    color: #FFFFFF;
    padding: 0;
}
div.mode-btn:hover, div.mode-btn:hover span{
    border-color: darkgreen;
    color: yellow;
    background: green;
}
div.side-menu {
    border: none;
    width: 100%;
    white-space: nowrap;
}
div.side-menu h4 {
    margin-top: 1em;
    margin-bottom: 0.8em;
}
div.side-menu a {
    color: #222222;
}
div.side-menu a:hover {
   color: red;
   text-decoration: none;
}
div.files-list {
    border: none;
    width: 250px;
    float: left;
    margin-bottom: 0.5em;
}
div.files-list a:hover {
   text-decoration: none;
   color: red;
}
span.icon {
    margin: 0 0 0 0;
    padding: 0 0.16em 0 0;
}
span.backlighting {
    color: red;
    background: yellow;
    font-weight: bold;
}

</style>

</head><body>

<table width="auto" border=0 align="center"><tr>
<td width="800px" valign="top">

