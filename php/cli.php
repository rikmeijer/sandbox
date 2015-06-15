<?php

function input()
{
	return fgets(STDIN);
}

echo "Please enter something: ";
echo input();