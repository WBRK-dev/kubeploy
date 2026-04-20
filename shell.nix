{ pkgs ? import <nixpkgs> {} }:

pkgs.mkShell {
  buildInputs = [
    pkgs.php
    pkgs.php84Packages.composer
    pkgs.nodejs
  ];
}
