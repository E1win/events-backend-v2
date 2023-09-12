<?php
namespace Framework\Model\Service;

/**
 * You can think of Services as "higher level Domain Objects", 
 * but instead of business logic, 
 * Services are responsible for interaction between Domain Objects and Mappers. 
 * These structures end up creating a "public" interface for
 * interacting with the domain business logic. 
 * You can avoid them, but at the penalty of leaking some domain logic into Controllers.
 */