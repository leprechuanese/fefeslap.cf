#! /usr/bin/perl -w
# Script para golpear en irssi.  Uso: “/golpear <víctima>”.

use strict;
use Irssi;

sub golpear
{
    my $frases  = '~/frases-de-fortuna';
    my $victima = shift;
    $victima =~ s/^\s*//;  # Borrar espacios a la izquierda.
    $victima =~ s/\s*$//;  # Borrar espacios a la derecha.
    my @mensaje = "/me golpea a $victima " . `fortune $frases`;
    Irssi::active_win->command(@mensaje);
}

Irssi::command_bind(golpear => \&golpear);
