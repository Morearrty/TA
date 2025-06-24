<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Member;
use App\Models\PageContent;
use App\Models\ActivityProposal;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page with statistics.
     */
    public function index()
    {
        // Get active members count
        $activeMembersCount = Member::where('status', 'active')->count();
        
        // Get districts count
        $districtsCount = District::count();
        
        // Get successful activity count
        $activitiesCount = ActivityProposal::where('status', 'approved')->count();
        
        // Get content for each section
        $sections = [
            'hero' => $this->getSectionContent('hero'),
            'about' => $this->getSectionContent('about'),
            'stats' => $this->getSectionContent('stats'),
            'gallery' => $this->getSectionContent('gallery'),
            'cta' => $this->getSectionContent('cta'),
            'login' => $this->getSectionContent('login'),
            'footer' => $this->getSectionContent('footer'),
        ];
        
        return view('welcome', compact(
            'activeMembersCount', 
            'districtsCount', 
            'activitiesCount', 
            'sections'
        ));
    }
    
    /**
     * Get content for a specific section
     *
     * @param string $section
     * @return array
     */
    private function getSectionContent(string $section): array
    {
        $contents = PageContent::where('section', $section)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
            
        $result = [];
        foreach ($contents as $content) {
            $result[$content->key] = $content->value;
        }
        
        return $result;
    }
}
