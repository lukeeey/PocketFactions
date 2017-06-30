<?php

namespace TheDiamondYT\PocketFactions\util;

interface RelationParticipator {

	public function describeTo(RelationParticipator $that);

	public function getColorTo(RelationParticipator $that);
}
