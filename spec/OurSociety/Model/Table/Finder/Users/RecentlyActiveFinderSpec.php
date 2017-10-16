<?php

namespace spec\OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use Cake\ORM\Table;
use OurSociety\Model\Table\Finder\Users\RecentlyActiveFinder;
use OurSociety\Model\Table\UsersTable;
use PhpSpec\ObjectBehavior;

class RecentlyActiveFinderSpec extends ObjectBehavior
{
    public function let(Table $table)
    {
        $this->beConstructedWith($table);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RecentlyActiveFinder::class);
    }

    public function it_invokes_the_correct_query(Query $query)
    {
        $query->where(['Users.last_seen IS NOT' => null])->willReturn($query);
        $query->orderDesc('Users.last_seen')->willReturn($query);
        $query->limit(UsersTable::LIMIT_DASHBOARD)->willReturn($query);

        $this->__invoke($query);
    }
}
